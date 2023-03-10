<?php
	// Treating this file as a custom-actions-ajax

	include "./src/global/header.php";
	//if this file does not have access to the class, then include it

	if(isset($_GET["function"])){
		$function_name = $_GET["function"];
		if(function_exists($function_name))
			$function_name();
	}
	
	function test(){
		if(!class_exists("DbConfig"))
			require_once("./src/classes/class-connection.php")
			;
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
		echo("worked");
	}