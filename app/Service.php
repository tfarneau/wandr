<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = ['user_id','slug','status','var1','var2','var3','var4','var5','var6'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($service){

        if($service['slug'] == "ga"){
            $name = "Google Analytics";
        }else if($service['slug'] == "slack"){
            $name = "Slack";
        }else{
            $name = "Undefined service";
        }

        $_service = [
            "id" => $service['id'],
            "user_id" => $service['user_id'],
            "slug" => $service['slug'],
            "name" => $name,
            "status" => $service['status'],
            "var1" => $service['var1'],
            "var2" => $service['var2'],
            "var3" => $service['var3'],
            "var4" => $service['var4'],
            "var5" => $service['var5'],
        	"var6" => $service['var6']
        ];

        return $_service;
    }

    public static function transformMany($services){
        foreach($services as $k => $v){
            $services[$k] = Service::transform($v);
        }
        return $services;
    }
}
