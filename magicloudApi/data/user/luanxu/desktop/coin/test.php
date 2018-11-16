<?php
/**
 * Created by PhpStorm.
 * User: 乱序
 * Date: 2018/3/30
 * Time: 10:38
 */
require_once "CoinList.class.php";
require_once "MysqlDB.class.php";
class coinDb extends MysqlDB {
    private static $instance = null;
    public static function getInstance(){
        if(!self::$instance instanceof coinList){
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function __construct()
    {
        $config = array(
            "host"=>"127.0.0.1",
            "port"=>"3306",
            "user"=>"root",
            "password"=>"beblog",
            "dbname"=>"coindb",
            "charset"=>"utf8"
        );
        parent::__construct($config);
    }
    public function userIsset($username){
        $sql = "SELECT user_name FROM user_coin WHERE user_name= '{$username}'";
        return $this->getRow($sql)['user_name'];
    }
    public function createUser($username,$coin){
        $sql = "INSERT INTO user_coin VALUES (null,'{$username}',$coin,NULL)";
        return $this->exec($sql);
    }
    public function addCoin($username,$coin){
        $oldTime = $this->getTime($username);
        $nowTime =  date("Y-m-d",time());
        if($oldTime!=$nowTime){
            $sql = "UPDATE user_coin set coin = coin +$coin,coin_time = '{$nowTime}' WHERE user_name = '{$username}'";
            return $this->exec($sql);
        }else {
            return false;
        }
    }
    public function getTime($username){
        $sql = "SELECT coin_time FROM user_coin WHERE user_name='{$username}'";
        return $this->getRow($sql)['coin_time'];
    }
    public function getCoin($username){
        $sql = "SELECT coin FROM user_coin WHERE user_name='{$username}'";
        return $this->getRow($sql)['coin'];
    }
    public function hasCoin($max){
        $sql = "SELECT coin_time FROM user_coin";
        $arr = array();
        $result = $this->findAll($sql);
        foreach ($result as $item){
            $arr[] =$item['coin_time'];
        }
        $today = date("Y-m-d",time());
        $count = 0;
        foreach ($arr as $item){
            if($item==$today){
                $count++;
            }
        }
        if($count>$max){
            return false;
        }else {
            return 10-$count;
        }
    }
}
date_default_timezone_set('PRC');
$config = require_once "./config.php";
$coinDb = coinDb::getInstance($config['coinDb'],2);
$username = rand(0,9999);
if(isset($username)){
    if($coinDb->userIsset($username)==false&&$username!=""){
        if($coinDb->createUser($username,$config['createCoin'])){
            echo $config['createUserMsg'];
        }else {
            echo "用户创建失败";
        }
    }
    $count = $coinDb->hasCoin($config['dayCoin']);
    $redis = coinList::getInstance();
    $redis->setCoinStore($count);
    if($redis->receiveCoin()>0){
        if(true){
        	if(date("H",time())*1>=9){
        		if($count>0){
        			if($coinDb->addCoin($username,$config['perCoin'])){
        				$nowCoin = $coinDb->getCoin($username);
        				echo $config['addMsg']."你现在有<span style='color: skyblue;font-weight: 700;'> {$nowCoin} </span>枚金币";
        			}else {
        				echo "你今天已经领过金币了！";
        			}
        		}else {
        			echo "今天的金币已经被领完了！";
        		}
        	}else {
        		echo "false";
        	}
        }
    }else {
        echo "今天的金币已经被领完了！";
    }
}
if(isset($_GET['count'])){
    $count = $coinDb->hasCoin($config['dayCoin']);
    if($count){
        echo $count;
    }else {
        echo "0";
    }
}
?>