<script src="https://cdn.tailwindcss.com"></script> 

<?php
	//include the functions
	include "functions.php";

	//just some global things to prevent re using stuff
	$connect = mysqli_connect(
		"db", 
		"php_docker",
		"password",
		"php_docker"
	);

	if(!$connect){
		echo("connection error");
		die();
	}
	
	$table_name = "main";