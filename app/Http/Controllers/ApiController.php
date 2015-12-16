<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function dashboard()
    {
        return view('debugger.dashboard');
    }

    public function simulator()
    {
        return view('debugger.simulator');
    }

    public function respond($status, $status_message, $data){
    	return [
    		"status" => $status,
    		"status_message" => $status_message,
    		"data" => $data
    	];
    }

    public function respondError($status_message, $error){
        return $this->respond(400, $status_message, $error);
    }

    public function respondErrors($status_message, $errors){
        return $this->respond(401, $status_message, ['errors' => $errors ]);
    }

    public function respondForbidden($status_message, $errors){
        return $this->respond(403, $status_message, ['error' => $errors ]);
    }

    public function respondInternalError($status_message, $errors){
        return $this->respond(500, $status_message, ['error' => $errors ]);
    }

    public function respondSuccess($status_message, $data){
    	return $this->respond(200, $status_message, $data);
    }

    public function getSpeed($mode,$type){

        $speed = 1;
        if($mode == "bike" && $type == "classic"){ $speed = 13; }
        if($mode == "bike" && $type == "sport"){  $speed = 18; }
        if($mode == "foot" && $type == "classic"){ $speed = 5; }
        if($mode == "foot" && $type == "sport"){ $speed = 10; }
        return $speed;

    }

    public function getRadius($time,$mode,$type){

        $speed = $this->getSpeed($mode,$type);

        $time_h = $time/60; // Convert time to hours
        $radius = round($speed*$time_h); // Km * Km/h = h

        $radius > 50 ? $radius = 50000 : $radius = $radius*1000; // Km to m
        $radius = round($radius - $radius/100*25); // - 25% radius

        return $radius;

    }
    
}
