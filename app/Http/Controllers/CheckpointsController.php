<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CheckpointsController extends ApiController
{
   
    public function index(Request $request)
    {   

        /*
            VENUE CATEGORIES : https://developer.foursquare.com/categorytree
            VENUE SEARCH : https://developer.foursquare.com/docs/venues/search
         */

        $FOURSQUARE = [
            "client_id" => "BADVPCD05TXDRQBVY3421JH0MVSHCGBEMG4EV1RWXB3RTBTO",
            "client_secret" => "QRLGDLTRRKH0UTD020KXOD3MFBZELPAQIRWHZOIQ4P40FNNQ",
            "categories" => [
                "4deefb944765f83613cdba6e", // historic site
                "5642206c498e4bfca532186c", // memorial site
                "4bf58dd8d48988d181941735", // museum
                "507c8c4091d498d9fc8c67a9", // public art
                "4bf58dd8d48988d184941735", // stadium
                "4bf58dd8d48988d182941735", // Input::get('ll')theme park
                "4bf58dd8d48988d17b941735", // zoo
                "4d4b7105d754a06377d81259", // outdoor
            ]
        ];

        $curl = new \Curl\Curl();

        $curl->get('https://api.foursquare.com/v2/venues/search', array(
            'client_id' => $FOURSQUARE['client_id'],
            'client_secret' => $FOURSQUARE['client_secret'],
            'categoryId' => implode(',',$FOURSQUARE['categories']),
            'intent' => 'browse', // checkin | browse | global
            'll' => Input::get('ll'), // latitude,longitude
            'radius' => Input::get('radius'),
            'v' => '20151212',
            'limit' => 50
        ));

        $response = json_decode($curl->response);

        if($response->meta->code != 200){
            return $this->respondError("REQUEST_FAILED",$response->meta);
        }else{

            // Transform data
            // --------------

            $data = [];
            foreach($response->response->venues as $v){
                $_v = [
                    'fs_id' => $v->id,
                    'name' => $v->name,
                    'lat' => $v->location->lat,
                    'lng' => $v->location->lng,
                    // 'stats' => $v->stats,
                    // 'url' => isset($v->url) ? $v->url : null
                ];

                $data[] = $_v;
            }

            // Get only limit
            // --------------

            $count = Input::has('limit') ? Input::get('limit') : 5;
            $_data = [];

            $rand_keys = array_rand($data, $count);
            foreach($rand_keys as $k){
                $_data[] = $data[$k];
            }

            return $this->respondSuccess("REQUEST_SUCCESS", $_data);
        }

    }
}
