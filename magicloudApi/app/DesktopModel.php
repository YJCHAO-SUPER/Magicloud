<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DesktopModel extends Model
{
    private static $desktopApps;
    public static function desktopApp($token){
        $desktop_path = User::getUserDesktop($token);
        self::$desktopApps = array(
            array(
                "type"		=> "folder",
                "content"	=> "我的文件",
                "icon"		=>   asset('icon/folder.png'),
                "name"		=> "我的文件",
                "menuType"	=> "systemBox menu-default",
                "ext"		=> 'oexe',
                "path"		=> User::getUserHome($token)
            ),
            array(
                "type"		=> "cmd",
                "content"	=> "控制台",
                "icon"		=>   asset('icon/terminal.png'),
                "name"		=> "控制台",
                "menuType"	=> "systemBox menu-default",
                "ext"		=> 'oexe',
                "path"		=> ""
            ),
            array(
                "type"		=> "chrome",
                "content"	=> "浏览器",
                "icon"		=>   asset('icon/Google_Chrome_icon_(2011).png'),
                "name"		=> "Google Chrome",
                "menuType"	=> "systemBox menu-default",
                "ext"		=> 'oexe',
                "path"		=> ""
            ),
        );
        self::readFile($desktop_path);
        return self::$desktopApps;
    }
    private static function readFile($path){
        if(is_dir($path)&&$path!="."&&$path!=".."){
            $handel = opendir($path);
            while ($resName = readdir($handel)) {
//                $resName = iconv("GBK","UTF-8",$resName);
                if($resName!="."&&$resName!=".."){
                    if(is_dir($path."/".$resName)){
                        $apps = self::$desktopApps;
                        array_push($apps,array(
                            "type"		=> "folder",
                            "content"	=> "文件夹",
                            "icon"		=>   asset('icon/folder.png'),
                            "name"		=> $resName,
                            "menuType"	=> "systemBox menu-default",
                            "ext"		=> '',
                            "path"		=> $path."\\".$resName
                        ));
                        self::$desktopApps = $apps;
                    }else{
                        $apps = self::$desktopApps;
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
                                $icon = asset('icon/js.png');
                                break;
                            }
                            case "css":{
                                $icon = asset('/icon/css.png');
                                break;
                            }
                            case "jpg":{
                                $icon = self::base64EncodeImage($path."/".$resName);
                                break;
                            }
                            case "png":{
                                $icon = self::base64EncodeImage($path."/".$resName);
                                break;
                            }
                            case "gif":{
                                $icon = self::base64EncodeImage($path."/".$resName);
                                break;
                            }
                            default : {
                                $icon = asset('icon/file.png');
                            }
                        }
                        array_push($apps,array(
                            "type"		=> "file",
                            "content"	=> "文件",
                            "icon"		=>   $icon,
                            "name"		=> $resName,
                            "menuType"	=> "systemBox menu-default",
                            "ext"		=> $ext,
                            "path"		=> $path."\\".$resName
                        ));
                        self::$desktopApps = $apps;
                    }
                }
            }
        }
    }
    public static function base64EncodeImage ($image_file) {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

}
