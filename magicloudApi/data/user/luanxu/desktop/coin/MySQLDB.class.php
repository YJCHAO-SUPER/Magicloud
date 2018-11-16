<?php 

	/*
	属性：

	数据库主机 host
	数据库用户名 user
	数据库密码 pwd
	数据库名称 dbname
	数据库编码格式 charset
	pdo对象  pdo


	方法：

	执行sql语句的方法 exec()
	获取所有的数据 findAll()
	获取一行 getRow();
	获取第一个字段  getFirstField()

	 */
	
	class MySQLDB{



		//写方法
		//连接数据库
        function __construct($config = array()){
            //连接数据库，并且给属性 pdo 赋值
            try{
                $host = isset($config['host'])? $config['host'] : 'localhost';
                $user = isset($config['user'])? $config['user'] : 'root';
                $password = isset($config['password'])? $config['password'] : '';
                $dbname = isset($config['dbname'])? $config['dbname'] : '';
                $port = isset($config['port'])? $config['port'] : '3306';
                $charset = isset($config['charset'])? $config['charset'] : 'utf8';

                $this->pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname}",$user,$password) or die('数据库连接错误');
                $this->pdo->exec("set names {$charset}");
            }catch(PDOException $e){
                echo "mysql connection fail!".$e->getMessage();

            }
        }
		// 执行sql语句的方法 exec()
		function exec($sql,$data=[]){
			//预处理的方式
			$stmt = $this->pdo->prepare($sql);
			//通过 execute 绑定数据
			return $stmt -> execute($data);
		}

		// 获取所有的数据 findAll()
		function findAll($sql,$data=[]){
			//select * from house_info where id = :id;
			$stmt = $this->pdo->prepare($sql);
			$arr = array();
			if($stmt->execute($data)){
				//取数据
				$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

			}
			return $arr;
		}
		// 获取一行 getRow();
		// $stmt->fetch(PDO::FETCH_ASSOC)
		function getRow($sql,$data=[]){

			$stmt = $this->pdo->prepare($sql);
			$arr = array();
			if($stmt->execute($data)){
				//取数据
				$arr = $stmt->fetch(PDO::FETCH_ASSOC);

			}
			return $arr;
		}
		 
		// 获取第一个字段  getFirstField()
		function getFirstField($sql,$data=[]){
			$stmt = $this->pdo->prepare($sql);
			$arr = array();
			if($stmt->execute($data)){
				//取数据
				$arr = $stmt->fetch(PDO::FETCH_NUM);

			}
			return $arr[0];
		}

		//在析构方法中，把pdo对象释放掉
		function __destruct(){
			//销毁对象
			$this->pdo = null;
		}

	}

/*	//实例化对象
	$mysql = new MySQLDB("localhost","root","123","housedb");
	$sql = "select * from house_info where id < :num";
	// 通过我们自己写的findAll方法查询数据
	$arr = $mysql->findAll($sql,array(":num"=>20));

	$sql = "select username from house_info where id = :id";
	// $num   553
	$num = $mysql->getFirstField($sql,array(":id"=>100));
	var_dump($num);*/

 ?>