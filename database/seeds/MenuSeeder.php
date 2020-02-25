<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


		DB::table("admin_menu")->insert([


		['parent_id'=>46,'title'=>'賽季','order'=>"16",'icon'=>'fa-adjust','uri'=>'seasons'],

		['parent_id'=>46,'title'=>'答題卷','order'=>"17",'icon'=>'fa-align-justify','uri'=>'papers'],
		['parent_id'=>0,'title'=>'學校管理','order'=>"11",'icon'=>'fa-bank','uri'=>null],
		['parent_id'=>55,'title'=>'學校','order'=>"0",'icon'=>'fa-building','uri'=>'schools'],
		['parent_id'=>55,'title'=>'學生','order'=>"0",'icon'=>'fa-user','uri'=>'students'],

		]);         



    }
}
