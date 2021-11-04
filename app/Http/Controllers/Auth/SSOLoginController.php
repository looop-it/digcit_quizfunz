<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\User;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SSOLoginController extends Controller
{
    public function callback(Request $request)
    {
        if ($request->has('action') && $request->has('st')) {
            $ssoUser = $this->getUser($request->st);

            try {
                DB::beginTransaction();

                $user = User::updateOrCreate(
                    ['uuid' => $ssoUser['uuid']],
                    [
                        'name' => $ssoUser['profile']['name'] ? $ssoUser['profile']['name'] : $ssoUser['uuid'],
                        'email' => $ssoUser['email'] ? $ssoUser['email'] : $ssoUser['uuid'].'@quizfunz.com',
                        'password' => bcrypt(str_random(16)),
                        'mobile' => $ssoUser['mobile'],
                        'verified' => true,
                    ]
                );

                if (array_key_exists('participant', $ssoUser)) {
                    Participant::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'name' => $ssoUser['participant']['name'],
                            'school_id' => $ssoUser['participant']['school']['id'],
                            'school_name' => $ssoUser['participant']['school']['name'],
                            'grade' => $ssoUser['participant']['school']['grade'],
                            'class' => $ssoUser['participant']['school']['class'],
                        ]
                    );
                }

                DB::commit();

                Auth::login($user);

                if ($request->has('redirectUrl')) {
                    return redirect()->away($request->redirectUrl);
                }

                return redirect()->route('home');
            } catch (\Exception $exception) {
                DB::rollback();

                \Log::error("Failed to sync user data. Error: {$exception->getMessage()}");

                abort(500);
            }
        }
    }

    private function getUser(string $token)
    {
        try {
            $client = new HttpClient([
                'verify' => !app()->isLocal(),
            ]);

            $response = $client->request('GET', config('quiz.api_url').'/user', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer {$token}",
                ],
            ]);

            $code = $response->getStatusCode(); // 200

            if ($code === 200) {
                $rawData = json_decode($response->getBody()->getContents(), true);

                return $rawData['data'];
            }

            return null;
        } catch (\Exception $exception) {
            \Log::error("Failed to get user info from core. Error: {$exception->getMessage()}");

            abort(500);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Logout remote user
        try {
            $client = new HttpClient([
                'verify' => !app()->isLocal(),
            ]);

            $query = http_build_query([
                'appId' => config('sso.access_key'),
                'callback' => config('sso.callback_url'),
            ]);

            $cookieJar = CookieJar::fromArray([
                'quizfunz_session' => $_COOKIE['quizfunz_session'],
            ], config('session.domain'));

            $client->request('GET', config('sso.url')."/slo?{$query}", [
                'cookies' => $cookieJar,
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to get user info from core. Error: {$exception->getMessage()}");
        }

        // Logout local user
        Auth::guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/');
    }
}
