<?php

namespace App\Http\Controllers;

use App\DesktopModel;
use App\User;
use Illuminate\Http\Request;
use App\Helper\FileUtil;
use Illuminate\Support\Facades\Cookie;

class CmdController extends Controller
{
    public function init(Request $req){
        $system = User::getUserSystem($req->token);
        $user = array(
            "title"=>"(".User::getUserName($req->token).")",
            "currentPath"=>User::getUserHome($req->token)
        );
        return $user;
    }
    public function index(Request $req){
        $cmdName = $req->cmd;
        $cmdArgs = $req->args;
        $system = User::getUserSystem($req->token);
        $currentPath = $req->currentPath;

        switch ($cmdName){
            // 查看文件
            case "ls":{
                $this->cmdLs($currentPath,$cmdArgs);
                break;
            }
            // 登录
            case "login": {
                break;
            }
            //切换到指定目录
            case "cd" : {
                $newpath =  $currentPath."\\".$cmdArgs[0];
                if(dirname($newpath)!=dirname(User::getUserHome($req->token))){
                    if(is_dir($newpath)){
                        $result = array(
                            "title"=>$newpath,
                            "currentPath"=>$newpath,
                            "msg"=>""
                        );
                    }else {
                        $result = array(
                            "msg"=>"没有这个目录，无法切换"
                        );
                    }
                }else {
                    $result = array(
                        "msg"=>"权限不足"
                    );
                }

                echo json_encode($result);
                break;
            }
            //创建目录
            case "mkdir" : {
                $result = array();
                $this->Directory($currentPath."\\".$cmdArgs[0],$result);
                echo json_encode($result);
                break;
            }
            //创建文件
            case "touch" : {
                $result = array();
                $this->cmdTouch($currentPath."\\".$cmdArgs[0],$result);
                echo json_encode($result);
                break;
            }
            //拷贝文件及文件夹
            case "cp" : {
                $result = array();
                $this->cmdCopy($currentPath."\\".$cmdArgs[0],$currentPath."\\".$cmdArgs[1],$result);
                echo json_encode($result);
                break;
            }
            //移动文件及目录
            case "mv" : {
                $result = array();
                if($cmdArgs[0]==null||$cmdArgs[1]==null){
                    $result = array(
                      "msg"=>"<span style='color: yellow;'>用法: mv [oldpath] [newpath]/[oldpath]</span>"
                    );
                }else {
                    $this->cmdMv($currentPath."\\".$cmdArgs[0],$currentPath."\\".$cmdArgs[1],$result);
                }
                echo json_encode($result);
                break;
            }
            //删除文件及目录
            case "rm" : {
                $result = array();
                $this->cmdRm($currentPath."\\".$cmdArgs[0],$result);
                echo json_encode($result);
                break;
            }
            //读取文件内容
            case "cat" : {
                $result = array();
                $this->cmdCat($currentPath."\\".$cmdArgs[0],$result);
                echo json_encode($result);
                break;
            }
            //帮助 显示所有指令
            case "help" : {
                $result = array();
                $this->cmdHelp($result);
                echo json_encode($result);
                break;
            }

            default:{
                $result = array(
                  "msg"=>"没有这个指令，help 指令获取帮助"
                );
                echo json_encode($result);
            }

        }
    }

    private function cmdLs($path,$args=null){
        if($args[0]!=null){
            $currentPath =$path."\\".$args[0];
        }else {
            $currentPath =$path;
        }
        $filestr = "";
        $this->readFile($currentPath,$filestr);
        $title = str_replace($currentPath,"~",$currentPath);
        $result = array(
            "msg"=>"\n".$filestr
        );
        echo json_encode($result);
    }

    private function readFile($path,&$str){
        if(is_dir($path)&&$path!="."&&$path!=".."){
            $handel = opendir($path);
            while ($resName = readdir($handel)) {
//                $resName = iconv("GBK","UTF-8",$resName);
                if($resName!="."&&$resName!=".."){
                    if(is_dir($path."/".$resName)){
                        $str.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"color:deepskyblue;\">{$resName}</span>\n";
                    }else{
                        $str.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{$resName}</span>\n";
                    }
                }
            }
        }
    }



//    创建目录
    private function Directory($path,&$result){

        if(is_dir($path)){
            $result = array(
              "msg"=>"目录已存在"
            );
        }else {
            if(is_dir($path) || @mkdir($path,0777)){
                $result = array(
                    "msg"=>"创建成功"
                );
            }else{
                $this->Directory(dirname($path),$result);
                if(@mkdir($path,0777)){
                    $result = array(
                        "msg"=>"创建成功"
                    );
                }
            }
        }
    }

//    创建文件
    private function cmdTouch($file_path,&$result){

        if(file_exists($file_path)){

            $result = array(
                "msg"=>"文件已存在"
            );
        }else{

            $fp = fopen($file_path,"w");
            fwrite($fp,"");
            fclose($fp);
            $result = array(
                "msg"=>"文件创建成功"
            );
        }
    }

//    拷贝文件及文件夹
    private function cmdCopy($path,$aimPath,&$result){

        if( is_dir ($path) || file_exists($path) ){
            $this->recurse_copy($path,$aimPath);
            $result = array(
                "msg"=>"OK"
            );
        }else{
            $result = array(
                "msg"=>"你要复制的不存在！"
            );
        }

    }
    private function recurse_copy($src,$dst) { // 原目录，复制到的目录

            $dir = opendir($src);


        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '' . $file);
                }
            }
        }
        closedir($dir);
    }

//    移动文件和文件夹
    private function cmdMv($file,$aimfile,&$result){

        if(is_dir($file)){
            $fileUtil = new FileUtil();
            $fileUtil->moveDir($file,$aimfile);
            $result = array(
                "msg"=>"OK"
            );
        }
        else if(is_file($file)){
            $fileUtil = new FileUtil();
            $fileUtil->moveFile($file,$aimfile);
            $result = array(
                "msg"=>"OK"
            );
        }
        else{
            $result = array(
                "msg"=>"没有找到要移动的文件或目录"
            );
        }

    }

//    删除文件和文件夹
    private function cmdRm($aimfile,&$result){

        if(is_dir($aimfile)){
            $fileUtil = new FileUtil();
            $fileUtil->unlinkDir($aimfile);
            $result = array(
                "msg"=>"OK"
            );
        }
        else if(file_exists($aimfile)){
            $fileUtil = new FileUtil();
            $fileUtil->unlinkFile($aimfile);
            $result = array(
                "msg"=>"OK"
            );
        }
        else{
            $result = array(
                "msg"=>"没有找到要删除的文件或目录"
            );
        }

    }

//    读取文件内容
    private function cmdCat($file_path,&$result){

        if(file_exists($file_path)){
            $str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
            $str = iconv("gbk","utf-8",$str);
            $result = array(
                "msg"=>"\n".$str,
                "clear"=>"true"
            );
        }else{
            $result = array(
                "msg"=>"没有找到该文件"
            );
        }
    }

    //帮助 显示所有指令
    private function cmdHelp(&$result){
        $result = array(
            "msg"=>"控制台可以使用的指令：\n 
             ls &lt;path&gt; 查看目录文件 \n 
             cd &lt;path&gt;切换到指定目录 \n 
             mkdir &lt;path&gt; 创建目录 \n 
             touch &lt;path&gt; 创建文件 \n 
             cat &lt;path&gt; 读取文件内容 \n
             cp &lt;oldpath&gt; &lt;newpath&gt;/&lt;rename&gt;复制文件/目录到指定目录 \n 
             mv &lt;oldpath&gt; &lt;newpath&gt;/&lt;oldpath&gt;  移动文件/目录到指定目录 \n 
             rm &lt;path&gt; 删除文件/目录 \n
             echo &lt;value&gt; 输出值"
        );
    }


}
