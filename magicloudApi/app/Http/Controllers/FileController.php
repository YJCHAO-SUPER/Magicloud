<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public  function getFile(Request $req){
        $path = $req->path;

        $resultArr = array();
        //        $file = array(
        //            "name"=>"baby",
        //            "type"=>"folder",
        //            "content"=>"",
        //            "icon"=>"icon/folder.png",
        //            "ext"=>"",
        //            "path"=>"E:\Magicloud\data\user\luanxu\baby"
        //        );
        $this->readFile($path,$resultArr);
        return $resultArr;
    }
//    遍历文件  取文件值
    private function readFile($path,&$resultArr){
        if(is_dir($path)&&$path!="."&&$path!=".."){
            $handel = opendir($path);
            while ($resName = readdir($handel)) {
//                $resName = iconv("GBK","UTF-8",$resName);
                if($resName!="."&&$resName!=".."){
                    if(is_dir($path."/".$resName)){
                                $file = array(
                                    "name"=>$resName,
                                    "type"=>"folder",
                                    "content"=>"",
                                    "icon"=>asset('icon/folder.png'),
                                    "ext"=>"",
                                    "path"=>$path."/".$resName
                                );
                    $resultArr[] =$file;
                    }else{
                        $ext = substr(strrchr($resName, '.'), 1);
                        $icon = "";
                        switch ($ext){
                            case "php":{
                                $icon = asset('icon/php.png');
                                break;
                            }
                            case "txt":{
                                $icon = asset('icon/txt.png');
                                break;
                            }
                            case "html":{
                                $icon = asset('icon/html.png');
                                break;
                            }
                            case "js":{
                                $icon = asset('/icon/js.png');
                                break;
                            }
                            case "css":{
                                $icon = asset('/icon/css.png');
                                break;
                            }
                            case "jpg":{
                                $icon = $this->base64EncodeImage($path."/".$resName);
                                break;
                            }
                            case "png":{
                                $icon = $this->base64EncodeImage($path."/".$resName);
                                break;
                            }
                            case "gif":{
                                $icon = $this->base64EncodeImage($path."/".$resName);
                                break;
                            }

                            default : {
                                $icon = asset('icon/file.png');
                            }
                        }
                        $file = array(
                            "name"=>$resName,
                            "type"=>"file",
                            "content"=>"",
                            "icon"=>$icon,
                            "ext"=>$ext,
                            "path"=>$path."/".$resName
                        );
                        $resultArr[] =$file;
                    }
                }
            }
        }
    }

    public function searchFile(Request $req){
        $path = $req->path;
        $name = $req->name;
        $resultArr = array();

        $this->dosearchFile($name,$path,$resultArr);
        return $resultArr;
    }

    //搜索文件
    private function dosearchFile($name,$path,&$resultArr){
        if(is_dir($path)&&$path!="."&&$path!=".."){
            $handel = opendir($path);
            while ($resName = readdir($handel)) {
//                $resName = iconv("GBK","UTF-8",$resName);
                if($resName!="."&&$resName!=".."){
                    if(is_dir($path."/".$resName)){
                        if($this->likeSearch($name,$resName)){
                            $file = array(
                                "name"=>$resName,
                                "type"=>"folder",
                                "content"=>"",
                                "icon"=>asset('icon/folder.png'),
                                "ext"=>"",
                                "path"=>$path."/".$resName
                            );
                            $resultArr[] = $file;
                        }
                        $this->dosearchFile($name,$path.'/'.$resName,$resultArr);
                    }else{
                        if($this->likeSearch($name,$resName)){
                            $ext = substr(strrchr($resName, '.'), 1);
                            $icon = "";
                            switch ($ext){
                                case "php":{
                                    $icon = asset('icon/php.png');
                                    break;
                                }
                                case "txt":{
                                    $icon = asset('icon/txt.png');
                                    break;
                                }
                                case "html":{
                                    $icon = asset('icon/html.png');
                                    break;
                                }
                                default : {
                                    $icon = asset('icon/file.png');
                                }
                            }
                            $file = array(
                                "name"=>$resName,
                                "type"=>"file",
                                "content"=>"",
                                "icon"=>$icon,
                                "ext"=>$ext,
                                "path"=>$path."/".$resName
                            );
                            $resultArr[] =$file;
                        }
                    }
                }
            }
        }
    }

    public function likeSearch($keyworld,$name){
        $length = mb_strlen($name);
        for ($i=0;$i<=$length;$i++){
            $str = "";
            for ($j=0;$j<$i;$j++){
                $str.=$name[$j];
            }
            if($keyworld==$str){
                return true;
            }
        }
        return false;
    }




}