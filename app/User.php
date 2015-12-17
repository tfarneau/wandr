<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function checkpoint_request(){
    	return $this->hasMany('App\CheckpointRequest', 'user_id', 'id');
    }

    public function itineraries(){
    	return $this->hasMany('App\Itinerary', 'user_id', 'id');
    }

    // -----------------
    // Transform methods
    // -----------------

    public static function transform($user){

        $_user = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'created_at' => $user['created_at'],
            'updated_ad' => $user['updated_ad']
        ];

        return $_user;
    }

    public static function transformMany($users){
        foreach($users as $k => $v){
            $users[$k] = User::transform($v);
        }
        return $users;
    }
}
