<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use App\Checkpoint;

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

        $radius = $this->getRadius(Input::get('time'),Input::get('mode'),Input::get('type'));
        $radius = $radius*0.6;

        $curl->get('https://api.foursquare.com/v2/venues/explore', array(
            'client_id' => $FOURSQUARE['client_id'],
            'client_secret' => $FOURSQUARE['client_secret'],
            'section' => 'outdoors',
            'venuePhotos' => '1',
            'll' => Input::get('ll'), // latitude,longitude
            'radius' => $radius,
            'v' => '20151212',
            'limit' => 50
        ));

        $response = json_decode($curl->response);

        $groups = $response->response->groups[0]->items;

        if($response->meta->code != 200){
            return $this->respondError("REQUEST_FAILED",$response->meta);
        }else{

            $items = $response->response->groups[0]->items;

            // Transform data
            // --------------

            $data = [];
            foreach($items as $item){

                $_item = [
                    'fs_id' => $item->venue->id,
                    'name' => $item->venue->name,
                    'lat' => $item->venue->location->lat,
                    'lng' => $item->venue->location->lng,
                    'checkin_count' => $item->venue->stats->checkinsCount,
                    'url' => isset($item->venue->url) ? $item->venue->url : null,
                    'rating' => isset($item->venue->rating) ? $item->venue->rating : null,
                    'address' => implode(', ', $item->venue->location->formattedAddress)
                ];

                $_item['photo_original'] = isset($item->venue->photos) && $item->venue->photos->count >= 1 ? $item->venue->photos->groups[0]->items[0]->prefix."500x500".$item->venue->photos->groups[0]->items[0]->suffix : null;
                $_item['photo_original'] = isset($item->venue->featuredPhotos) && $item->venue->featuredPhotos->count >= 1 ? $item->venue->featuredPhotos->items[0]->prefix."500x500".$item->venue->featuredPhotos->items[0]->suffix : null;
                $_item['tip'] = isset($item->tips) && count($item->tips) >= 1 ? $item->tips[0]->text : null;

                $data[] = $_item;

            }

            // Get only limit
            // --------------

            $count = Input::has('limit') ? Input::get('limit') : 9;
            $_data = [];

            $rand_keys = array_rand($data, $count);
            foreach($rand_keys as $k){
                $_data[] = $data[$k];
            }

            // Save the data un DB
            // -------------------

            foreach($data as $item){

                $v = Validator::make($item, 
                    [
                        'fs_id' => 'unique:checkpoints',
                        'lat' => 'required',
                        'lng' => 'required',
                        'name' => 'required'
                    ]
                );

                // $checkpoints = new Checkpoint($item);
                // !$v->fails() ? $checkpoints->save() : null; 

                if(!$v->fails()){

                    $checkpoint = new Checkpoint($item);

                    /*if($checkpoint['photo_original'] !== null){
                        $url = $checkpoint['photo_original'];
                        $destinationPath = public_path().'/img/venues/'.md5($checkpoint['fs_id']).'.jpg';
                        file_put_contents($destinationPath, file_get_contents($url));
                        $checkpoint['photo_saved'] = md5($checkpoint['fs_id']).'.jpg';
                    }*/

                     $checkpoint['photo_saved'] = "not_saved";

                    $checkpoint->save();

                }

            }

            return $this->respondSuccess("REQUEST_SUCCESS", $_data);
        }

    }
}
