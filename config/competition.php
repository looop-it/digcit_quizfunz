<?php

return [
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

    // Define weekly ranking range weekOfYear => range.
    'weekly_ranking_range' => [
        // First week start at 03-11
        '10' => [
            'start_date' => '2020-03-2',
            'end_date' => '2020-03-8',
        ],
        '11' => [
            'start_date' => '2020-03-9',
            'end_date' => '2020-03-15',
        ],

        '12' => [
            'start_date' => '2020-03-16',
            'end_date' => '2020-03-22',
        ],

        '13' => [
            'start_date' => '2020-03-23',
            'end_date' => '2020-03-29',
        ],

        '14' => [
            'start_date' => '2020-03-30',
            'end_date' => '2020-04-05',
        ],

        '15' => [
            'start_date' => '2020-04-06',
            'end_date' => '2020-04-12',
        ],

        '16' => [
            'start_date' => '2020-04-13',
            'end_date' => '2020-04-19',
        ],

        '17' => [
            'start_date' => '2020-04-20',
            'end_date' => '2020-04-26',
        ],

        '18' => [
            'start_date' => '2020-04-27',
            'end_date' => '2020-05-03',
        ],

        '19' => [
            'start_date' => '2020-05-04',
            'end_date' => '2020-05-10',
        ],

        '20' => [
            'start_date' => '2020-05-11',
            'end_date' => '2020-05-17',
        ],

        '21' => [
            'start_date' => '2020-05-18',
            'end_date' => '2020-05-24',
        ],
        '22' => [
            'start_date' => '2020-05-25',
            'end_date' => '2020-05-31',
        ],
    ],
];
