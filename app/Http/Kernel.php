<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            'throttle:120,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'auth.verified' => \App\Http\Middleware\CheckUserVerified::class,

        // School
        'google-recaptcha-v2' => \App\Http\Middleware\GoogleRecaptchaV2::class,

        // Competition releated.
        'RedirectIfParticipateCacheExists' => \App\Http\Middleware\RedirectIfParticipateCacheExists::class,
        'CheckIsMobile' => \App\Http\Middleware\CheckIsMobile::class,
        'VerifyParticipantInfo' => \App\Http\Middleware\VerifyParticipantInfo::class,
        'CheckOpenSeason'=> \App\Http\Middleware\CheckOpenSeason::class,
        'CheckCompetitionTime' => \App\Http\Middleware\CheckCompetitionTime::class,
        'SingleParticipation' => \App\Http\Middleware\SingleParticipation::class,
        'CheckTimesLimit' =>  \App\Http\Middleware\CheckTimesLimit::class,
        'CheckDailyTimesLimit' =>  \App\Http\Middleware\CheckDailyTimesLimit::class,
        'CheckTimeInterval' =>  \App\Http\Middleware\CheckTimeInterval::class,
        'CheckUserPaperExists' => \App\Http\Middleware\CheckUserPaperExists::class,
        'CheckPaperTimeout' => \App\Http\Middleware\CheckPaperTimeout::class,
        'CheckQuestionTimeout' => \App\Http\Middleware\CheckQuestionTimeout::class,

    ];
}
