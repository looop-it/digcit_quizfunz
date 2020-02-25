<?php

use Illuminate\Database\Seeder;

class FeaturesAddTabeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		DB::table("features")->insert([

		['title'=>'首页头条资讯','order1'=>'0','status'=>"1"],

		['title'=>'最新消息头条资讯','order1'=>'0','status'=>"1"],

		['title'=>'首页banner','order1'=>'1','status'=>"1",]

		]);       



    }
}
