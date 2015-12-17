<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Toin0u\Geotools\Facade\Geotools;

use App\Checkpoint;
use App\Itinerary;

use \GoogleMaps;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ItinerariesController extends ApiController
{

    public function index($id = null)
    {

        if($id == null){
            $itineraries = JWTAuth::parseToken()->authenticate()->itineraries;
        }else{
            $user = JWTAuth::parseToken()->authenticate();
            $itinerary = Itinerary::where('id', (int) $id)->where('user_id', $user['id'])->first();
            if($itinerary == null){
                return $this->respondError('NOT_FOUND',null);
            }else{
                $itineraries = [$itinerary];
            }
        }

        return $this->respondSuccess('SUCCESS', Itinerary::transformMany($itineraries));
    }

    public function favorites()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $itineraries = Itinerary::where('favorite', 1)->where('user_id', $user['id'])->get();
        
        if($itineraries == null){ $itineraries = []; }

        return $this->respondSuccess('SUCCESS', Itinerary::transformMany($itineraries));
    }

    public function favorite($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $update = Itinerary::where('id', $id)->where('user_id', $user['id'])->update(['favorite' => 1]);

        if($update == true){
            return $this->respondSuccess('SUCCESS', Itinerary::where('id', $id)->first()); 
        }else{
            return $this->respondError('ERROR_UPDATING', $id); 
        }
    }

    public function unfavorite($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $update = Itinerary::where('id', $id)->where('user_id', $user['id'])->update(['favorite' => 0]);

        if($update == true){
            return $this->respondSuccess('SUCCESS', Itinerary::where('id', $id)->first()); 
        }else{
            return $this->respondError('ERROR_UPDATING', $id); 
        }
    }

    public function calculate(Request $request){

    	$distance = $this->getRadius(Input::get('time'),Input::get('mode'),Input::get('type'));
        $initial_distance = $distance;
    	
    	$settings = [
    		'fs_ids' => explode(',', Input::get('fs_ids')),
    		'time' => Input::get('time'),
    		'mode' => Input::get('mode'),
    		'type' => Input::get('type'),
            'll' => explode(',', Input::get('ll'))
    	];

        $checkpoints = Checkpoint::whereIn('fs_id', $settings['fs_ids'])->get(); // replace id by fs_id

        $coords_start = Geotools::coordinate($settings['ll']);

        foreach($checkpoints as $k => $v){
            $coords_point = Geotools::coordinate([$v['lat'], $v['lng']]);
            $checkpoints[$k]['distance'] = round(Geotools::distance()->setFrom($coords_start)->setTo($coords_point)->flat());
        }

        $itinerary = [];

        // On prend un premier checkpoint aléatoire
        // $index = rand(0, count($checkpoints)-1);
        // $random_checkpoint = $checkpoints[$index];

        // On l'ajoute à l'itinéraire
        // $itinerary[] = $random_checkpoint;

        // On enlève la distance au radius
        // $distance -= $random_checkpoint['distance'];

        // On retire l'élément des checkpoints
        // unset($checkpoints[$index]);

        // On teste la distance restante
            // Si elle est proche de la distance à la maison, on rentre
            // Si il reste du temps, on cherche le checkpoint le plus proche et on y va
            // Et on recommence

        $continue = true;
        $home_checkpoint = [
            'name' => 'home',
            'lat' => $settings['ll'][0],
            'lng' => $settings['ll'][1]
        ];
        $last_checkpoint = $home_checkpoint;

        // On ajoute le checkpoint home
        $itinerary[] = $home_checkpoint;

        // On prend un premier checkpoint aléatoire
        $index = rand(0, count($checkpoints)-1);
        $random_checkpoint = $checkpoints[$index];

        // On l'ajoute à l'itinéraire
        $itinerary[] = $random_checkpoint;

        // On enlève la distance au radius
        $distance -= $random_checkpoint['distance'];

        // On retire l'élément des checkpoints
        unset($checkpoints[$index]);

        // Tant qu'on doit continuer
        while($continue){

            $min_distance = 999*999;
            $selected_checkpoint = null;

            // Si il n'y a plus de checkpoints
            if(count($checkpoints) == 0){

                // On arrête
                $continue = false;
                $distance_from_start = Geotools::distance()->setFrom($coords_start)->setTo(Geotools::coordinate([$itinerary[count($itinerary)-1]['lat'], $itinerary[count($itinerary)-1]['lng']]))->flat();
                $distance -= $distance_from_start;
                $itinerary[] = $home_checkpoint;

            }else{

                foreach($checkpoints as $k => $v){

                    $coords_lastcheckpoint = Geotools::coordinate([$last_checkpoint['lat'], $last_checkpoint['lng']]);
                    $coords_point = Geotools::coordinate([$v['lat'], $v['lng']]);
                    $distance_from_last = Geotools::distance()->setFrom($coords_lastcheckpoint)->setTo($coords_point)->flat();
                    if($distance_from_last < $min_distance){
                        $selected_checkpoint = $k;
                        $min_distance = $distance_from_last;
                    }
                    $last_checkpoint = $checkpoints[$k];

                }

                $distance_from_start = Geotools::distance()->setFrom($coords_start)->setTo(Geotools::coordinate([$checkpoints[$selected_checkpoint]['lat'], $checkpoints[$selected_checkpoint]['lng']]))->flat();
                $distance_from_start = $distance_from_start*1.5;

                if($distance_from_start > $distance){

                    $itinerary[] = $home_checkpoint;
                    $distance -= $distance_from_start;
                    $continue = false;  

                }else{

                    $distance_from_last = Geotools::distance()
                        ->setFrom(Geotools::coordinate([$checkpoints[$selected_checkpoint]['lat'],$checkpoints[$selected_checkpoint]['lng']]))
                        ->setTo(Geotools::coordinate([$itinerary[count($itinerary)-1]['lat'], $itinerary[count($itinerary)-1]['lng']]))
                        ->flat();
                    $distance -= $distance_from_last;

                    $itinerary[] = $checkpoints[$selected_checkpoint];
                    unset($checkpoints[$selected_checkpoint]);

                }

            }


        }

        // Get total distance
        $totaldistance = 0;

        $coords_last = null;
        $gmapurl = "https://www.google.fr/maps/dir/";
        // $gmapurl = "https://www.google.fr/maps/dir/50.55989,1.69239/50.57337,1.64882/50.57337,1.643/@50.5757916,1.6410379,13z";

        foreach($itinerary as $k => $v){
            $gmapurl .= $v['lat'].",".$v['lng'].'/';
            if($k == count($itinerary)-1){
                $gmapurl .= '@'.$v['lat'].",".$v['lng'].',13z/data=!3m1!4b1!4m2!4m1!3e2'; // pieds
                // $gmapurl .= '@'.$v['lat'].",".$v['lng'].',13z/data=!3m1!4b1!4m2!4m1!3e1'; // velo
            }


            $coords_actual = Geotools::coordinate([$v['lat'], $v['lng']]);
            if($coords_last != null){
                $totaldistance += round(Geotools::distance()->setFrom($coords_actual)->setTo($coords_last)->flat());
            }
            $coords_last = $coords_actual;
        }

        $waypoints = [];
        foreach($itinerary as $k => $v){
            $waypoints[] = $v['lat'].','.$v['lng'];
        }

        // return $coords;

        $direction = GoogleMaps::load('directions')
            ->setParam([
                'origin' => $waypoints[0], 
                'destination' =>  $waypoints[0], 
                'waypoints' => $waypoints,
                'language' => 'fr',
                'mode' => $settings['mode'] == 'bike' ? 'bicycling' : 'walking' // bicycling
            ])
           ->get();

        $direction = json_decode($direction,true);

        $metas = [
            'calc_distance' => $distance,
            'calc_totaldistance' => $totaldistance,
            'calc_gmapurl' => $gmapurl,
            'total_distance' => 0,
            'total_time' => 0,
            'speed' => 1,
        ];

        $polyline = $direction['routes'][0]['overview_polyline'];
        
        // Get route and meta

        $route = [];
        foreach($direction['routes'][0]['legs'] as $v){
            $metas['total_distance'] += $v['distance']['value'];
            $metas['total_time'] += $v['duration']['value'];

            $_route = [
                'distance' => $v['distance']['value'],
                'steps' => []
            ];

            foreach($v['steps'] as $v2){
                $_route['steps'][] = [
                    'distance' => $v2['distance']['value'],
                    'instruction' => strip_tags($v2['html_instructions']),
                ];
            }

            $route[] = $_route;

        }

        unset($route[0]); // Remove first
        unset($route[count($route)]); // Remove last

        // Get speed

        $speed = $this->getSpeed($settings['mode'],$settings['type']);

        $metas['speed'] = $speed;
        $metas['time_h'] = $metas['total_distance']/1000/$speed;
        $metas['time_minutes'] = $metas['time_h']*60;

        // Time string

        $seconds = $metas['time_minutes']*60;
        $hours = floor($seconds / (60 * 60));
        $divisor_for_minutes = $seconds % (60 * 60);
        $minutes = floor($divisor_for_minutes / 60);
        $divisor_for_seconds = $divisor_for_minutes % 60;
        $seconds = ceil($divisor_for_seconds);

        $time_obj = array(
            "h" => (int) $hours,
            "m" => (int) $minutes,
            "s" => (int) $seconds,
        );


        if($time_obj['h'] > 0){
            $metas['time_string'] = $time_obj['h'].'h'.$time_obj['m'];
        }else{
            $metas['time_string'] = $time_obj['m'].'min';
        }

        $metas['total_distance_string'] = round($metas['total_distance']/1000,1).'km';
        // $route = $direction['routes'][0]['legs'];

        $return = [
            'metas' => $metas,
            'direction' => $route,
            'polyline' => $polyline,
            'checkpoints' => $itinerary
        ];

        // Save data

        $user = JWTAuth::parseToken()->authenticate();

        $save_itinerary = $return;
        $save_itinerary['user_id'] = $user['id'];
        $save_itinerary['metas'] = json_encode($save_itinerary['metas']);
        $save_itinerary['direction'] = json_encode($save_itinerary['direction']);
        $save_itinerary['polyline'] = json_encode($save_itinerary['polyline']);
        $save_itinerary['checkpoints'] = json_encode($save_itinerary['checkpoints']);
        
        $itinerary = new Itinerary($save_itinerary);
        $itinerary->save();

        return $this->respondSuccess("SUCCESS", Itinerary::transform($itinerary));

        // retourner un linestring geojson
        // étapes
        // checkpoints séléctionnés
        // temps / distance

    }

}
