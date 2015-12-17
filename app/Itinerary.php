<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $table = 'itineraries';

    protected $fillable = ['metas','direction','polyline','checkpoints','user_id','favorite'];

    public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($itinerary){

        $_itinerary = [
        	"id" => $itinerary['id'],
			"metas" => json_decode($itinerary['metas']),
			"direction" => json_decode($itinerary['direction']),
			"polyline" => json_decode($itinerary['polyline']),
			"checkpoints" => json_decode($itinerary['checkpoints']),
			"user_id" => $itinerary['user_id'],
			"favorite" => $itinerary['favorite'],
			"created_at" => $itinerary['created_at'],
			"updated_at" => $itinerary['updated_at']
        ];

        return $_itinerary;
    }

    public static function transformMany($itinerarys){
        foreach($itinerarys as $k => $v){
            $itinerarys[$k] = Itinerary::transform($v);
        }
        return $itinerarys;
    }
}
