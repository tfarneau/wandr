<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    protected $table = 'generators';

    protected $fillable = ['user_id','ga_service_id','slack_service_id','ga_account','name','ga_property','ga_profile','slack_channel','start_date','end_date','template','activation_hours','timezone','activation_days'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

    public function analytics_service(){
        return $this->hasOne('App\Service', 'id', 'ga_service_id');
    }

    public function slack_service(){
        return $this->hasOne('App\Service', 'id', 'slack_service_id');
    }

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($generator){

        $_generator = [
        	"id" => $generator['id'],
            "user_id" => $generator['user_id'],
            "ga_service_id" => $generator['ga_service_id'],
            "slack_service_id" => $generator['slack_service_id'],
            "name" => $generator['name'],
            "ga_service" => $generator['ga_service'],
            "ga_account" => $generator['ga_account'],
            "ga_property" => $generator['ga_property'],
            "ga_profile" => $generator['ga_profile'],
            "slack_channel" => $generator['slack_channel'],
            "start_date" => $generator['start_date'],
            "end_date" => $generator['end_date'],
            "template" => $generator['template'],
            "timezone" => $generator['timezone'],
            "activation_hours" => $generator['activation_hours'],
            "activation_days" => $generator['activation_days'],
        ];

        return $_generator;
    }

    public static function transformMany($generators){
        foreach($generators as $k => $v){
            $generators[$k] = Generator::transform($v);
        }
        return $generators;
    }

    // -------------
    // Other methods
    // -------------

}
