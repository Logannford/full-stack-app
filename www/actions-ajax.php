<?php
	// Treating this file as a custom-actions-ajax

	include "./src/global/header.php";
	
	//including all of the classes that we need - will make a better way of doing this in the future
	if(!class_exists("DbConfig"))
		require_once("./src/classes/class-connection.php");

	if(!class_exists("SqlQuery"))
		require_once("./src/classes/class-query.php");

	//checking which function the ajax is requesting
	if(isset($_GET["function"])){
		$function_name = $_GET["function"];
		if(function_exists($function_name))
			$function_name();
	}
	
	/**
	 * Just a test function to insert data into the db
	 */
	function test(){
		//everything inside this file will be outputted in the v-html
		//stripping tags - make a function in the future to do what 'sanitize_text_field' does
		$person_name = sanitize_string($_GET["first_name"]);
		$person_dob = strip_tags($_GET["dob"]);
		$date_created = date("Y-m-d");
		$table_name = "main";
		
		//this will insert the names and dob's got from the ajax on every page refresh
		$sql_query = 
			//we are inserting into the table name specified above
			"INSERT INTO $table_name
			(name, dob, date_created)
			VALUES ('$person_name', '$person_dob', '$date_created')";

		//query using a new DbConfig object
		$db = new DbConfig();
		//creating a new sqli query but passing in the query params and the db connection via the object created above
		mysqli_query($db->connection, $sql_query);
	}

	/**
	 * This function needs to first strip the tags of any malicious things
	 * then create a new 'insert' method on a new DbConfig class
	 */
	function add_new_user_to_db(){
		//check no bad things in the username
		$username = sanitize_string($_GET["username"]);
		$password = sanitize_string($_GET["password"]);
		//create a


		//if the return value is null - throw an error which will throw an error on the front end
		if(is_null($username) || is_null($password))
			return false;

		//set up some args for the user_exists check
		$args = [
			"table_name"		=> "users",
			"username"			=> $username
		];

		//lets check here if the user already exists before creating a new user object
		$database_connection = new SqlQuery();
		$user_exists = $database_connection->user_exists($args);

		if($user_exists){
			// this function will make a new username until there is one not already in the db
			echo("sorry that username is taken, why not try?");
			echo("<br>");
			echo(suggest_new_username($username));
			return;
		}
		else
			echo("Success!");
		
		//$enter_user_to_db = new User();
		//$enter_user_to_db = $enter_user_to_db->sign_user_up();
	}