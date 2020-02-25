<?php

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seasons = [
            [
                'name' => '大灣區學界知識爭霸戰',
                'start_at' => '2019-10-01 00:00:00',
                'end_at' => '2019-10-31 23:59:59',
                'is_intercollegiate' => true
            ]
        ];

        foreach ($seasons as $season) {
            Season::create($season);
        }
    }
}
