<?php

return [
    'id' => env('QUIZ_ID'),
    'target' => env('QUIZ_TARGET', 'secondary'),
    'api_url' => env('QUIZ_API_URL', 'https://api.quizfunz.com'),
    'profile_edit_url' => env('QUIZ_PROFILE_EDIT_URL', 'https://quizfunz.com/user/profile/edit'),
];
