<?php
	//check we have the config class 
	if(!class_exists("DbConfig"))
		require_once("./class-connection.php");

	class User extends DbConfig{
		protected $username;
		protected $email_address;

		//make sure password is some-what secure
		protected $password;

		public function __construct(array $args){
			// create a connection on construct
			parent::__construct();	
			//setters
			$this->username 		= $args["username"];
			$this->email_address 	= $args["email_address"];
			$this->password 		= $args["password"];
		}
		/**
		 * This method will only run AFTER we check if the user
		 * DOES NOT exist 
		 * - we do this in actions.ajax.php
		 * 
		 * @param string username
		 * 
		 * @param string email_address
		 * 
		 * @param string password
		 * 
		 * 
		 * if the user creates - true: if cannot be created - throw error (false)
		 * @return bool
		 */
		public function sign_user_up(){
			
		}
	}