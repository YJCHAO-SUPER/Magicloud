<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function getContent(Request $req){
        if($req->token&&$req->path){
            $result = array();
            $path = $req->path;
            if(is_file($req->path)){
                $str = file_get_contents($path);//将整个文件内容读入到一个字符串中
//                $str = iconv("gbk","utf-8",$str);

                $ext = substr(strrchr($req->path, '.'), 1);
                $language = "";
                switch ($ext){
                    case "php":{
                        $language = "php";
                        break;
                    }
                    case "js":{
                        $language = "javascript";
                        break;
                    }
                    case "html":{
                        $language = "html";
                        break;
                    }
                    case "css":{
                        $language = "css";
                        break;
                    }
                    default:{
                        $language = "txt";
                    }
                }
                $result = array(
                  "code"=>"200",
                  "language"=>$language,
                  "content"=>$str
                );
            }else {
                $result = array(
                    "code"=>"421"
                );
            }
            return $result;
        }
    }
    public function saveContent(Request $req){
        $result = "";
        if($req->token&&$req->path) {
            $content = $req->filecontent;
            if($content!=""){
                file_put_contents($req->path,$content);
                $result = array(
                    "code"=>"200"
                );
            }else {
                $result = array(
                    "code"=>"432"
                );
            }
        }else {
            $result = array(
                "code"=>"431"
            );
        }
        return $result;

    }
}
