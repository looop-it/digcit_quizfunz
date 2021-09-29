<?php

return [
    'url' => env('SSO_URL', 'https://sso.quizfunz.com'),
    'access_key' => env('SSO_ACCESS_KEY', null),
    'access_secret' => env('SSO_ACCESS_SECRET', null),
    'callback_url' => env('SSO_CALLBACK_URL', null),
];
