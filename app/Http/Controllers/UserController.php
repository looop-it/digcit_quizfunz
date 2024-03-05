<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\Participant;
use App\Models\Paper;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Hash;
use App\Jobs\Registration\SendSchoolRegistrationConfirmEmail;
use App\Jobs\SendAccountRegistrationConfirmEmail;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        
        return view('home.mine')->with('user', $user);
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 提示
     */
    public function msg()
    {
        return view('home.comm.msg');
    }

    /**
     * Verify user by token.
     *
     * @param Request $request
     * @return void
     */
    public function verify(Request $request)
    {
        if ($request->token) {
            DB::beginTransaction();

            try {
                $user = User::where([
                    ['verification_token', $request->token],
                    // ['verified', false]
                ])->first();

                if ($user) {
                    if (!$user->isVerified()) {
                        $user->update([
                            'verified' => true
                        ]);
    
                        DB::commit();
                    }
                    
                    return view('verification.user.success');
                }

                return view('verification.user.failed');
            } catch (\Exception $exception) {
                DB::rollback();

                \Log::error("Failed to verify user account by token. Error: {$exception->getMessage()}");
            }
        }

        return redirect()->route('home');
    }

    /**
     * User not verified.
     *
     * @param Request $request
     * @return void
     */
    public function notVerified(Request $request)
    {
        return view('auth.not_verified');
    }

    /**
     * Resend verification email.
     *
     * @param Request $request
     * @return void
     */
    public function resendVerificationToken(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                // Dispatch job to send activation email.
                dispatch(new SendAccountRegistrationConfirmEmail($user));

                return response()->json([
                    'status' => '200',
                    'message' => 'Verification email resent.'
                ], 200);
            }
        } catch (\Exception $exception) {
            \Log::error("Failed to resend verification email. Error: {{$exception->getMessage()}}");
        }

        return response()->json([
            'status' => '500',
            'message' => 'Internal server error.'
        ], 500);
    }

    public function profile()
    {
        $user = Auth::user();

        $papers = $user->papers()->with('season')->finished()->orderBy('started_at', 'desc')->count();
        $participant = $user->participant();
        return view('profile', compact(['user', 'participant', 'papers']));
    }
}
