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

    public function respond($status, $status_message, $data){
    	return [
    		"status" => $status,
    		"status_message" => $status_message,
    		"data" => $data,
            "count" => count($data)
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
    
}
