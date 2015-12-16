<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Toin0u\Geotools\Facade\Geotools;

use App\Checkpoint;

class ItinerariesController extends ApiController
{

    public function calculate(Request $request){

    	$distance = $this->getRadius(Input::get('time'),Input::get('mode'),Input::get('type'));
        $initial_distance = $distance;
    	
    	$settings = [
    		'fs_ids' => explode(',', Input::get('fs_ids')),
    		'time' => Input::get('time'),
    		'mode' => Input::get('mode'),
    		'style' => Input::get('type'),
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

        return [
            'checkpoints' => $itinerary,
            'initial_distance' => $initial_distance,
            'distance' => $distance,
            'totaldistance' => $totaldistance,
            'gmapurl' => $gmapurl
        ];

        // retourner un linestring geojson
        // étapes
        // checkpoints séléctionnés
        // temps / distance

    }

}
