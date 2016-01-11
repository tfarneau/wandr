<?php namespace App;
 
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
 
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
 
    use Authenticatable, CanResetPassword;
 
    protected $table = 'users';
 
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];
 
    protected $hidden = ['password', 'remember_token'];

    public function generators(){
        return $this->hasMany('App\Generator', 'user_id', 'id');
    }

    public function reports(){
        return $this->hasMany('App\Report', 'user_id', 'id');
    }

    public function services(){
        return $this->hasMany('App\Service', 'user_id', 'id');
    }

    public function activities(){
        return $this->hasMany('App\Activity', 'user_id', 'id');
    }

    // -----------------
    // Transform methods
    // -----------------

    public static function transform($user){

        $_user = [
            'id' => $user['id'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
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
