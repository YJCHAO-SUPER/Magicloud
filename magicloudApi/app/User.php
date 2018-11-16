<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password','roll','group','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public static function getUserHome($token){
        $user = User::where('api_token',$token)->first();
        if($user){
            $username = $user->name;
           $userHome = base_path('data\user\\'.$username);
            return  $userHome;
        }else {
            return false;
        }
    }

    public static function getUserDesktop($token){
        $user = User::where('api_token',$token)->first();
        if($user){
            $username = $user->name;
            $userDesktop = base_path('data\user\\'.$username.'\desktop');
            return  $userDesktop;
        }else {
            return false;
        }
    }
    public static function getUserSystem($token){
        $user = User::where('api_token',$token)->first();
        if($user){
            $username = $user->name;
            $userSystem = base_path('data\system\\'.$username);
            return  $userSystem;
        }else {
            return false;
        }
    }
    public static function getUserName($token){
        $user = User::where('api_token',$token)->first();
        if($user) {
            $username = $user->name;
            return $username;
        }else {
            return false;
        }
    }
}
