<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    protected $fillable = ['id','user_id','service_id','type','name','ga_id'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function service()
	{
		return $this->belongsTo('App\User', 'service_id');
	}

}
