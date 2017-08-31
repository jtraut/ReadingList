<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create the books table
		Schema::create('books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('author');			
			$table->text('details')->nullable();
			$table->string('genre');	
			$table->date('published')->nullable();
			$table -> integer('userID') -> unsigned() -> default(0);
			$table->foreign('userID')
					->references('id')->on('users')
					->onDelete('cascade');
			$table->string('slug');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		//remove the table
		Schema::drop('books');
    }
}
