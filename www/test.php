<?php
	include "./src/global/header.php"; 

	//everything inside this file will be outputted in the v-html
	//stripping tags - make a function in the future to do what 'sanitize_text_field' does
	$person_name = strip_tags($_GET["first_name"]);
	$person_dob = strip_tags($_GET["dob"]);
	$date_created = date("Y-m-d");
	
	$query = 
		"INSERT INTO $table_name 
		(name, dob, date_created) 
		VALUES ('$person_name', '$person_dob', '$date_created')";
	mysqli_query($connect, $query);