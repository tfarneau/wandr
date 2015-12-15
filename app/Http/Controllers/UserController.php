<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
// use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;

class UserController extends ApiController
{
    public function __construct(){
        // $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->respondForbidden('INVALID_CREDENTIALS', 'invalid_credentials');
            }
        } catch (JWTException $e) {
            return $this->respondInternalError('JWT_EXCEPTION', 'could_not_create_token');
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
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
            $user = new User($v->getData());
            $user->save();
            return $this->respondSuccess('USER_ADDED', $v->getData());
        }

    }

}
