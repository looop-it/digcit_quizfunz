<?php

namespace App\Jobs;

use App\Models\SchoolRegistration;
use App\Imports\UserImport;
use App\Models\StudentListImportLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ImportStudentList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SchoolRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = StudentListImportLog::where('school_registration_id', $this->registration->id)
                                    ->where('status', 'new')
                                    ->first();

        if ($log) {
            $path = $this->getFilePath($log->file_name);
            
            $log->update([
                'status' => 'processing'
            ]);

            $import = new UserImport($this->registration->school->id);
            $import->import($path, 'local');

            $log->update([
                'status' => 'finished',
                'statistics' => [
                    'total_count' => $import->getTotalCount(),
                    'imported_count' => $import->getImportedCount(),
                    'failed_count' => $import->getFailedCount(),
                    'failed_records' => $import->getFailedRecords()
                ]
            ]);

            Storage::disk('local')->delete($path);
        }
    }

    private function getFilePath($fileName)
    {
        $name = now()->format('ymdhis');
        $extension = pathinfo($fileName)['extension'];

        $file = Storage::get($fileName);

        Storage::disk('local')->put("{$name}.{$extension}", $file);

        return "{$name}.{$extension}";
    }
}
