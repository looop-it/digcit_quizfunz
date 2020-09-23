<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRegistrationRequest;
use App\Jobs\Registration\SendSchoolRegistrationVerifyEmail;
use App\Models\School;
use App\Models\SchoolRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolRegistrationController extends Controller
{
    /**
     * Show registration form.
     *
     * @return void
     */
    public function show()
    {
        $schools = School::approved()
                        ->ofType('secondary')
                        ->select(['name as text', 'id'])
                        ->orderBy('id', 'asc')
                        ->get();

        return view('school.register', compact('schools'));
    }

    /**
     * Store registration
     *
     * @param StoreSchoolRegistrationRequest $request
     * @return void
     */
    public function store(StoreSchoolRegistrationRequest $request)
    {
        try {
            $registration = SchoolRegistration::create([
                'school_id' => $request->school_id,
                'address' => $request->address,
                'name' => $request->name,
                'subject' => $request->subject,
                'email' => $request->email,
                'phone' => $request->phone,
                'verification_token' => str_random(64)
            ]);

            // Dispatch job to send email for school registration.
            if ($registration) {
                dispatch(new SendSchoolRegistrationVerifyEmail($registration));
            }

            return redirect()->route('school_registration.registered');
        } catch (\Exception $exception) {
            \Log::error("Failed to create school registration. Error: {$exception->getMessage()}");

            return back();
        }
    }

    public function registered()
    {
        return view('school.registered');
    }

    /**
     * Verify registration.
     *
     * @param Request $request
     * @return void
     */
    public function verify(Request $request)
    {
        if (!$request->token) {
            $message = '驗證連結有錯誤，請檢查連結是否完整!';

            return view('errors', [
                'message' => $message
            ]);
        }

        $registration = SchoolRegistration::where('verification_token', $request->token)->first();

        if (!$registration) {
            $message = '驗證連結有錯誤，請檢查連結是否完整!';

            return view('errors', [
                'message' => $message
            ]);
        }

        if ($registration->verified) {
            return redirect()->route('school_registration.verified')->with('verified', true);
        }

        DB::beginTransaction();

        try {
            $registration->update([
                'verified' => true,
                'verified_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('school_registration.verified')->with('verified', true);
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error("Failed to update school verification status. Error: {$exception->getMessage()}");
        }

        return view('errors', [
            'message' => '發生未知錯誤，請稍後重試！'
        ]);
    }

    /**
     * Show verified page.
     *
     * @return void
     */
    public function verified()
    {
        if (session()->has('verified')) {
            return view('school.verified');
        }

        return redirect()->route('home');
    }
}
