<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;

class GoogleRecaptchaV2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->validate([
            'g-recaptcha-response' => 'required'
        ], [
            'required' => '請驗證「我不是機器人」'
        ]);

        if (!$this->verify($request->input('g-recaptcha-response'))) {
            return back()->withErrors(['g-recaptcha-response' => '認證失敗，請重試']);
        }

        return $next($request);
    }

    private function verify(string $token = null) : bool
    {
        $client = new Client();

        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('googlerecaptchav2.secret_key'),
                'response' => $token,
            ]
        ]);

        $code = $response->getStatusCode();
        $content = json_decode($response->getBody()->getContents());

        if ($code === 200 && $content->success === true) {
            return true;
        }

        return false;
    }
}
