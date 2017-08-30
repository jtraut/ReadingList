<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    //genres table in database
	protected $guarded = [];
	
	public function books()
	{
		return $this->belongsToMany('App\Books');
	}
}
