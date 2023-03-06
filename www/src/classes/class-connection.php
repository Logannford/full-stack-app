<?php 

	class DbConfig{
		protected $servername;
		protected $username;
		protected $password;
		protected $dbname;

		public $connection;

		//when the class is created - 
		public function __construct(){
			$this->servername = "db";
			$this->username = "php_docker";
			$this->password = "password";
			$this->dbname = "php_docker";

			//set the connection to null
			$this->connection = null;
			//try to connect to the database
			try{
				//using the mysqli connect function
				$this->connection = mysqli_connect(
					$this->servername,
					$this->username,
					$this->password,
					$this->dbname
				);
				//if any error is caught - throw this
			}catch (Exception $e){
				echo("there was an error connecting to the db");
			}
		}
	}