<?php

return [
    'id' => env('QUIZ_ID'),
    'target' => env('QUIZ_TARGET', 'secondary'),
    'ranking_push_url' => env('QUIZ_RANKING_PUSH_URL', null)
];
