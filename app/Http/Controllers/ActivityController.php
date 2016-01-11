<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Activity;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ActivityController extends ApiController
{

    public function index()
    {

        $activities = JWTAuth::parseToken()->authenticate()->activities;

        if($activities == null){
            return $this->respondError('NOT_FOUND',[]);
        }else{
            return $this->respondSuccess('SUCCESS', Activity::transformOutMany($activities));
        }

    }

    public function show($id)
    {
        
        $user = JWTAuth::parseToken()->authenticate();
        $activity = Activity::where('id', $id)->where('user_id', $user['id'])->first();
        
        if($activity == null){
            return $this->respondError('NOT_FOUND', []);
        }else{
            return $this->respondSuccess('SUCCESS', Activity::transformOut($activity));
        }

    }

    public function store()
    {
        
    }
    
    public function update()
    {
        
    }

    public function delete()
    {
    
    }

}
