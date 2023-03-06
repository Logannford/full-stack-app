<?php
	include "./src/global/header.php";
	include "./src/classes/class-connection.php";
	//everything inside this file will be outputted in the v-html
	//stripping tags - make a function in the future to do what 'sanitize_text_field' does
	$person_name = seo_friendly_url($_GET["first_name"]);
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