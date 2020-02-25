<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MenuSeeder::class);
        $this->call(FeaturesAddTabeSeeder::class);
        
        $this->call(SeasonsTableSeeder::class);
        $this->call(QuestionCategoriesTableSeeder::class);
        $this->call(ScopesTableSeeder::class);
        // $this->call(QuestionsTableSeeder::class);
    }
}
