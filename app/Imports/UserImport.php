<?php

namespace App\Imports;

use App\Models\Participant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection, WithStartRow
{
    use Importable;

    public $schoolId;
    public $totalCount;
    public $importedCount;
    public $failedCount;
    public $failedRecords;

    public function __construct(int $schoolId)
    {
        $this->schoolId = $schoolId;
        $this->totalCount = 0;
        $this->importedCount = 0;
        $this->failedCount = 0;
        $this->failedRecords = [];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            if ($row[1] != null && $row[4] != null && $row[5] != null) {
                ++$this->totalCount;

                try {
                    DB::beginTransaction();

                    $email = $this->cleanup($row[4]);
                    $password = $this->cleanup($row[5]);

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        throw new \Exception("Email is not valid");
                    }

                    // Create account
                    $user = User::updateOrCreate(
                        ['email' => $email],
                        [
                            'name' => $row[1],
                            'password' => bcrypt($password),
                            'mobile' => $row[6],
                            'verified' => true,
                            'source' => 'quizfunz',
                            'register_way' => 'school_register'
                        ]
                    );

                    // Create participant info
                    Participant::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'school_id' => $this->schoolId,
                            'name' => $row[1],
                            'grade' => $row[2],
                            'class' => $row[3]
                        ]
                    );

                    DB::commit();

                    ++$this->importedCount;
                } catch (\Exception $exception) {
                    DB::rollback();

                    ++$this->failedCount;

                    $this->failedRecords[] = [
                        'row' => $index + 1,
                        'email' => $row[4]
                    ];

                    \Log::error("Failed to create user. Email: {$email}. Error: {$exception->getMessage()}");
                }
            }
        }

        unset($rows);
    }

    public function startRow(): int
    {
        return 4;
    }

    public function getTotalCount() : int
    {
        return $this->totalCount;
    }

    public function getImportedCount() : int
    {
        return $this->importedCount;
    }

    public function getFailedCount() : int
    {
        return $this->failedCount;
    }

    public function getFailedRecords() : array
    {
        return $this->failedRecords;
    }

    private function cleanup($value)
    {
        return str_replace(["\n", " "], '', trim($value));
    }
}
