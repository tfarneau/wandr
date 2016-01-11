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
        $user = User::find(Auth::user()->id)->first();
        return view('users.edit')->with(compact('user'));
    }

    public function save(Request $request){
        $inputs = $request->all();

        $user = User::find(Auth::user()->id);
        $user->fill($inputs);
        $user->save();

        return redirect()->back()->with('message', 'Account saved !');
    }

    public function dashboard(){

        // Get services

        $services = Service::transformMany(Auth::user()->services->toArray());

        $ga_services = [];
        $slack_services = [];

        foreach($services as $v){
            if($v['slug'] == "ga"){
                array_push($ga_services,$v);
            }else if($v['slug'] == "slack"){
                array_push($slack_services,$v);
            }
        }

        // Get generators

        $generators = Generator::where('user_id', Auth::user()->id)->get();

        return view('pages.dashboard')->with([
            'ga_services' => $ga_services,
            'slack_services' => $slack_services,
            'generators' => $generators
        ]);
    }

    /*public function register(Request $request)
    {

        $v = Validator::make(
            $request->all(), 
            [
                'email' => 'required|unique:users|max:255',
                'name' => 'required|max:255',
                'password' => 'required|min:8'
            ],
            [
                'required' => ':attribute est requis.',
                'unique' => ':attribute doit être unique.',
                'max' => ':attribute doit compter :max caractères maximum',
                'min' => ':attribute doit compter :min caractères minimum',
            ]
        );


        if ($v->fails())
        {
            return $this->respondErrors('ERROR_ADDING_USER', $v->errors());
        }
        else
        {

            $user = new User([
                'email' => $v->getData()['email'],
                'name' => $v->getData()['name'],
                'password' => Hash::make($v->getData()['password']),
            ]);


            $credentials = [
                'email' => $v->getData()['email'],
                'password' => $v->getData()['password']
            ];

            $user->save();

            // Test if user is invited by someone

            if($request->get('invited')){

                $invitant_user = User::where('email', $request->get('invited'))->first();

                if($invitant_user != null){
                    $update = User::where('id', $invitant_user['id'])->increment('max_generators');

                    $activity = new Activity([
                        'user_id' => $invitant_user['id'],
                        'type' => 'invited_user',
                        'var1' => $invitant_user['max_generators']+1,
                        'var2' => $user['email'],
                        'var3' => $user['name']
                    ]);
                    $activity->save();
                }

            }
            
            $token = JWTAuth::attempt($credentials);

            return $this->respondSuccess('USER_ADDED', compact('token'));

        }

    }*/

}
