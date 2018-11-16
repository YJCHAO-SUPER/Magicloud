<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $req){
        $result = array();
        $user = User::where('name',$req->name)->first();
        if($user){
            if($req->password==$user->password){
                $result = array(
                  "code"=>200,
                  "token"=>$user->api_token,
                  "home_path"=>User::getUserHome($user->api_token),
                  "desktop_path"=>User::getUserDesktop($user->api_token),
                  "msg"=>"登陆成功"
                );
            }else {
                $result = array(
                    "code"=>411,
                    "msg"=>"登陆失败，密码错误"
                );
            }
        }else {
            $result =  array(
                "code"=>412,
                "msg"=>"登陆失败，用户不能存在"
            );
        }
        return $result;
    }
}
