<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    protected $table = 'checkpoints';

    protected $fillable = ['fs_id','name','lat','lng','checkin_count','photo_original','photo_saved','url','rating','address','tip'];

	// -----------------
    // Transform methods
    // -----------------

    public static function transform($checkpoint){

        $_checkpoint = [
        	"fs_id" => $checkpoint['fs_id'],
			"name" => $checkpoint['name'],
			"lat" => $checkpoint['lat'],
			"lng" => $checkpoint['lng'],
			"checkin_count" => $checkpoint['checkin_count'],
			"url" => $checkpoint['url'],
			"rating" => $checkpoint['rating'],
			"address" => $checkpoint['address'],
			"photo_original" => $checkpoint['photo_original'],
			"tip" => $checkpoint['tip']
        ];

        return $_checkpoint;
    }

    public static function transformMany($checkpoints){
        foreach($checkpoints as $k => $v){
            $checkpoints[$k] = Checkpoint::transform($v);
        }
        return $checkpoints;
    }
}