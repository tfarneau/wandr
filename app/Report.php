<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = ['user_id','generator_id','text'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($report){

        $_report = [
            "id" => $report['id'],
            "user_id" => $report['user_id'],
            "generator_id" => $report['generator_id'],
            "text" => $report['text']
        ];

        return $_report;
    }

    public static function transformMany($reports){
        foreach($reports as $k => $v){
            $reports[$k] = Report::transform($v);
        }
        return $reports;
    }
}
