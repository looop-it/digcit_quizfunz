<?php

namespace App\Http\Controllers;

use App\Imports\QuestionImport;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Scope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class QuestionImportController extends Controller
{
    private $categories;
    private $levels;
    private $scopes;

    public function __construct()
    {
        $this->categories = $this->getCategories();
        $this->levels = $this->getDifficulties();
        $this->scopes = $this->getScopes();
    }

    public function import(Request $request)
    {
        $startTime = now();

        // Read data row from uploaded file.
        try {
            $questions = Excel::toArray(new QuestionImport(), $request->file('file'));
        } catch (\Exception $exception) {
            \Log::error('Cannot read import file. Error: '.$exception->getMessage());

            dd($exception->getMessage());
        }

        // Exclude header row
        $total = (count($questions[0]) - 1) / 4;
        $success = 0;

        // Store data row to DB
        foreach ($questions[0] as $key => $value) {
            // Skip header row
            if ($key == 0) {
                continue;
            }

            DB::beginTransaction();

            try {
                if ($isQuestion = $this->isQuestion($key)) {
                    $question = $this->storeQuestion(
                        $this->questionDataMapping($value)
                    );

                    ++$success;
                }

                if (isset($question)) {
                    $question->answers()->create(
                        $this->answerDataMapping($value, $isQuestion)
                    );
                }

                DB::commit();
            } catch (\Exception $exception) {
                DB::rollback();

                \Log::error("Cannot store question / answer. Key: {$key}. Error: {$exception->getMessage()}");
            }
        }

        $secondsUsed = now()->diffInSeconds($startTime);

        return response()->json([
            'message' => "{$success} / {$total}  imported. Time: {$secondsUsed} seconds",
        ], 200);
    }

    private function isQuestion($key)
    {
        return $key % 4 == 1;
    }

    /**
     * Get question difficulty levels.
     *
     * @return void
     */
    private function getDifficulties()
    {
        return [
            '低' => '1',
            '淺' => '1',
            '中' => '2',
            '高' => '3',
            '難' => '3',
        ];
    }

    /**
     * Get available scopes.
     *
     * @return array
     */
    private function getScopes()
    {
        return Scope::select('id', 'name')->get()->flatMap(function ($item, $key) {
            return [$item['name'] => $item['id']];
        })->all();
    }

    /**
     * Get available question categories.
     *
     * @return array
     */
    private function getCategories()
    {
        return QuestionCategory::select('id', 'name')->get()->flatMap(function ($item, $key) {
            return [$item['name'] => $item['id']];
        })->all();
    }

    public function storeQuestion($data)
    {
        return Question::create($data);
    }

    /**
     * Return question data format for storage.
     */
    private function questionDataMapping(array $data): array
    {
        $categoryName = trim($data[1]);
        $level = trim($data[2]);
        $scopeName = trim($data[3]);
        $name = trim($data[4]);
        // $reference = trim($data[6]);

        return [
            'name' => $name,
            'category_id' => $this->getCategoryId($categoryName),
            'level' => $this->levels[$level] ?? '4',
            'scope_id' => 1, //$this->getScopeId($scopeName),
            // 'reference' => $reference
        ];
    }

    /**
     * Get category id by name.
     *
     * @param string $name
     *
     * @return void
     */
    private function getCategoryId($name)
    {
        if (!array_key_exists($name, $this->categories)) {
            $category = QuestionCategory::create([
                'name' => $name,
            ]);

            return $category->id;
        }

        return $this->categories[$name];
    }

    /**
     * Get category id by name.
     *
     * @param string $name
     *
     * @return void
     */
    private function getScopeId($name)
    {
        if (!array_key_exists($name, $this->scopes)) {
            $scope = Scope::create([
                'name' => $name,
            ]);

            return $scope->id;
        }

        return $this->scopes[$name];
    }

    /**
     * Return answer data format for storage.
     */
    private function answerDataMapping(array $data, bool $correct): array
    {
        return [
            'content' => trim($data[5]),
            'correct' => $correct,
        ];
    }
}
