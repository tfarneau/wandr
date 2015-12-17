<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckpointRequest extends Model
{
    protected $table = 'checkpoints_requests';

    protected $fillable = ['user_id','lat','lng','time','mode','type'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($request){

        $_request = [
	        "id" => $request['id'],
			"user_id" => $request['user_id'],
			"lat" => $request['lat'],
			"lng" => $request['lng'],
			"time" => $request['time'],
			"mode" => $request['mode'],
			"type" => $request['type'],
			"created_at" => $request['created_at'],
			"updated_at" => $request['updated_at']
        ];

        return $_request;
    }

    public static function transformMany($requests){
        foreach($requests as $k => $v){
            $requests[$k] = CheckpointRequest::transform($v);
        }
        return $requests;
    }

}
