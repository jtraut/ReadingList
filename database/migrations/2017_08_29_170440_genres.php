<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Genres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//genres table
		Schema::create('genres', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
		});
		
		DB::table('genres')->insert(['name' => "Fiction"]);		
		
		DB::table('genres')->insert(['name' => "Drama"]);
	
		DB::table('genres')->insert(['name' => "Romance"]);	

		DB::table('genres')->insert(['name' => "Comedy"]);		
		
		DB::table('genres')->insert(['name' => "Horror"]);
	
		DB::table('genres')->insert(['name' => "Mystery"]);
		
		DB::table('genres')->insert(['name' => "Non-fiction"]);		
		
		DB::table('genres')->insert(['name' => "Satire"]);
	
		DB::table('genres')->insert(['name' => "Tragedy"]);
		
		DB::table('genres')->insert(['name' => "Fantasy"]);		
		
		DB::table('genres')->insert(['name' => "Mythology"]);
	
		DB::table('genres')->insert(['name' => "SciFi"]);
		
		DB::table('genres')->insert(['name' => "Classic"]);
		
		DB::table('genres')->insert(['name' => "Adventure"]);		
		
		DB::table('genres')->insert(['name' => "Biography"]);
	
		DB::table('genres')->insert(['name' => "Essay"]);		
		
		DB::table('genres')->insert(['name' => "History"]);				
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove the table
		Schema::drop('genres');
    }
}
