<?php

return [
    // vue: existing Vue page and /api/initialize, /api/question, /api/question/submit.
    // page: server-rendered questions with a one-time submit token.
    'answer_mode' => env('ANSWER_MODE', 'vue'),

    'global' => [
        'paper_time_limit_buffer' => 100,
        'question_time_limit_buffer' => 2,

        /*緩存*/
        'global_cache' => env('GLOBAL_CACHE', 0),
        'paper_id_cache' => env('PAPER_ID_CACHE', 0),   /*試卷id緩存*/
        'paper_cache' => env('PAPER_CACHE', 0),       /* 試卷緩存*/
        'sponsors_cache' => env('SPONSORS_CACHE', 0),
        'school_cache' => env('SCHOOL_CACHE', 0),
        'page_cache' => env('PAGE_CACHE', 0),
        'reference_cache' => env('REFERENCE_CACHE', 0),
        'post_cache' => env('POST_CACHE', 0),
        'ad_cache' => env('AD_CACHE', 0),
    ],

    'season' => [
        'season_cache' => env('SEASON_CACHE', 30),         /* 賽季緩存*/
    ],
];
