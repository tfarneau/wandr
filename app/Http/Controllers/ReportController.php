<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Generator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ReportController extends ApiController
{

    public function index()
    {

        $reports = JWTAuth::parseToken()->authenticate()->reports;

        if($reports == null){
            return $this->respondError('NOT_FOUND',[]);
        }else{
            return $this->respondSuccess('SUCCESS', Report::transformMany($reports));
        }

    }

    public function show($id)
    {
        
        $user = JWTAuth::parseToken()->authenticate();
        $report = Report::where('id', $id)->where('user_id', $user['id'])->first();
        
        if($report == null){
            return $this->respondError('NOT_FOUND', []);
        }else{
            return $this->respondSuccess('SUCCESS', Report::transform($report));
        }

    }

    public function update()
    {
        
    }

    public function store()
    {
        
    }

    public function delete()
    {
    
    }

}
