<?php
include_once "Predis/Autoloader.php";
Predis\Autoloader::register();
class CoinList {
    private static $instance = null;
    private $client;
    private $username;
    private function __construct()
    {
        $config = array(
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        );
        $this->client = new Predis\Client($config);
        // $this->client->auth("liancoin");
        $this->client->select(4);
        //清理一遍
        $this->client->flushdb();
    }
    public function setCoinStore($count){
        $date = date('Ymd');
        //库存名
        $kc = $date.'kc';
        //设置库存
        $this->client->setNx($kc,$count);
    }
    //单例模式
    static public function getInstance(){

        if(!self::$instance instanceof coinList){
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function receiveCoin(){
        $date = date('Ymd');
        //库存名
        $kc = $date.'kc';
        return $this->client->decr($kc)*1+1;
    }
}


//$a = new Redis();
//phpinfo();
?>