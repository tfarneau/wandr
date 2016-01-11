<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = ['user_id','type','var1','var2','var3'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($activity){

        $_activity = [
            "id" => $activity['id'],
            "user_id" => $activity['user_id'],
            "type" => $activity['type'],
            "var1" => $activity['var1'],
            "var2" => $activity['var2'],
            "var3" => $activity['var3']
        ];

        return $_activity;
    }

    public static function transformMany($activities){
        foreach($activities as $k => $v){
            $activities[$k] = Activity::transform($v);
        }
        return $activities;
    }

    // ---------------------
    // Transform out methods
    // ---------------------

    public static function transformOut($activity){

        $_activity = $activity;

        if($_activity['type'] == "invited_user"){
            $_activity['text'] = "You invited ".$_activity['var3']." (".$_activity['var2']."), and ou have now ".$_activity['var1']." max generators !";
        }

        return $_activity;
    }

    public static function transformOutMany($activities){
        foreach($activities as $k => $v){
            $activities[$k] = Activity::transformOut($v);
        }
        return $activities;
    }
}
