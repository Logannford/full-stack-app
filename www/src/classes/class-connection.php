<?php 
	/**
	 * Used to create new connections to the database
	 */

	class DbConfig{
		//variables are protected so they can be accessed via other classes that inherit this class
		protected $servername;
		protected $username;
		protected $password;
		protected $dbname;

		//the connection is public so we can use it  
		public $connection;

		//when the class is created this constructor is called - 
		public function __construct(){
			//setting everything up first - these are the standard username and passwords from the yml file
			$this->servername = "db";
			$this->username = "php_docker";
			$this->password = "password";
			$this->dbname = "php_docker";

			//set the connection to null
			$this->connection = null;
			//try to connect to the database
			try{
				//using the mysqli connect function to make a connection to the 
				//db when a new object of this class is made
				$this->connection = mysqli_connect(
					$this->servername,
					$this->username,
					$this->password,
					$this->dbname
				);
				//if any error is caught - throw this
			}catch (Exception $e){
				echo("there was an error connecting to the db" . $e);
				die();
			}
		}
	}