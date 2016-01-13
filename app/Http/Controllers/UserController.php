<?php

namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

use App\User;
use App\Activity;
use App\Service;
use App\Generator;

class UserController extends ApiController
{
    public function __construct(){
        // $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function edit(){
        $user = User::where('id',Auth::user()->id)->first();
        return view('users.edit')->with(compact('user'));
    }

    public function save(Request $request){
        $inputs = $request->all();

        $user = User::where('id',Auth::user()->id)->first();
        $user->fill($inputs);
        $user->save();

        return redirect()->back()->with('message', 'Account saved !');
    }

    public function dashboard(){

        // Get services

        $count = [
            'reports' => Auth::user()->reports->count(),
            'services_slack' => Auth::user()->services->where('slug','slack')->count(),
            'services_stats' => Auth::user()->services->where('slug','ga')->count(),
            'generators' => Auth::user()->generators->count()
        ];

        // Get generators

        return view('pages.dashboard')->with(compact('count'));

    }

}
