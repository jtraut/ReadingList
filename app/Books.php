<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
	protected $guarded = [];
	
	public function getUser()
	{
		return $this->belongsTo('App\User','userID');
	}

	public function genre()
	{
		return $this->belongsTo('App\Genre');
	}
}
