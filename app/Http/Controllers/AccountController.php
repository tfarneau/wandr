<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

use App\Account;
use App\Service;

class AccountController extends Controller
{

    public function populate($id = null)
    {

        $service = Service::where('user_id', Auth::user()->id)->where('id', (int) $id)->first();

        if($service){

            if($service['slug'] == "ga"){
                
                // Delete old accounts
                Account::where('service_id', $service['id'])->delete();
                
                
            }
        }else{
            return 'error';
        }

    }

}
