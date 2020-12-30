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
        2020 => [
            // 43 => [
            // "start_date" => "2020-10-19",
            // "end_date" => "2020-10-25",
            // ],
            // 44 => [
            // "start_date" => "2020-10-26",
            // "end_date" => "2020-11-01",
            // ],
            // 45 => [
            // "start_date" => "2020-11-02",
            // "end_date" => "2020-11-08",
            // ],
            // 46 => [
            // "start_date" => "2020-11-09",
            // "end_date" => "2020-11-15",
            // ],
            // 47 => [
            // "start_date" => "2020-11-16",
            // "end_date" => "2020-11-22",
            // ],
            // 48 => [
            // "start_date" => "2020-11-23",
            // "end_date" => "2020-11-29",
            // ],
            // 49 => [
            // "start_date" => "2020-11-30",
            // "end_date" => "2020-12-06",
            // ],
            // 50 => [
            // "start_date" => "2020-12-07",
            // "end_date" => "2020-12-13",
            // ],
            // 51 => [
            // "start_date" => "2020-12-14",
            // "end_date" => "2020-12-20",
            // ],
            // 52 => [
            // 'start_date' => '2020-12-21',
            // 'end_date' => '2020-12-27',
            // ],
            53 => [
            'start_date' => '2020-12-28',
            'end_date' => '2021-01-03',
            ],
        ],
        2021 => [
            1 => [
            'start_date' => '2021-01-04',
            'end_date' => '2021-01-10',
            ],
            2 => [
            'start_date' => '2021-01-11',
            'end_date' => '2021-01-17',
            ],
            3 => [
            'start_date' => '2021-01-18',
            'end_date' => '2021-01-24',
            ],
            4 => [
            'start_date' => '2021-01-25',
            'end_date' => '2021-01-31',
            ],
            5 => [
            'start_date' => '2021-02-01',
            'end_date' => '2021-02-07',
            ],
            6 => [
            'start_date' => '2021-02-08',
            'end_date' => '2021-02-14',
            ],
            7 => [
            'start_date' => '2021-02-15',
            'end_date' => '2021-02-21',
            ],
            8 => [
            'start_date' => '2021-02-22',
            'end_date' => '2021-02-28',
            ],
            9 => [
            'start_date' => '2021-03-01',
            'end_date' => '2021-03-07',
            ],
            10 => [
            'start_date' => '2021-03-08',
            'end_date' => '2021-03-14',
            ],
            11 => [
            'start_date' => '2021-03-15',
            'end_date' => '2021-03-21',
            ],
            12 => [
            'start_date' => '2021-03-22',
            'end_date' => '2021-03-28',
            ],
        ],
    ],
];
