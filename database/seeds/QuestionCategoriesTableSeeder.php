<?php

use Illuminate\Database\Seeder;
use App\Models\QuestionCategory;

class QuestionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '通用',
            '香港',
            '廣州',
            '中山',
            '佛山',
            '惠州',
            '東莞',
            '江門',
            '深圳',
            '澳門',
            '珠海',
            '肇慶'
        ];

        foreach ($categories as $category) {
            QuestionCategory::create([
                'name' => $category
            ]);
        }
    }
}
