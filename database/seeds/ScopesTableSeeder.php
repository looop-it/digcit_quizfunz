<?php

use Illuminate\Database\Seeder;
use App\Models\Scope;

class ScopesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scopes = [
            '歷史文化',
            '經濟',
            '小知識',
            '政策'
        ];

        foreach ($scopes as $scope) {
            Scope::create([
                'name' => $scope
            ]);
        }
    }
}
