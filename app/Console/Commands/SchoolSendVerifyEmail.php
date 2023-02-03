<?php

namespace App\Console\Commands;

use App\Jobs\Registration\SendSchoolRegistrationVerifyEmail;
use App\Models\SchoolRegistration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SchoolSendVerifyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:send-verify-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send verification email to school.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schools = SchoolRegistration::where('verified', false)->get();

        foreach ($schools as $school) {
            if (!$school->verification_token) {
                $this->updateVerificationToken($school);
            }

            dispatch(new SendSchoolRegistrationVerifyEmail($school));
        }
    }

    private function updateVerificationToken(SchoolRegistration $school)
    {
        DB::beginTransaction();

        try {
            $school->update([
                'verification_token' => str_random(64),
            ]);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error("Failed to update verification token of school. Error: {$exception->getMessage()}");
        }

        return false;
    }
}
