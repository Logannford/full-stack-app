<!-- the cdn for the tailwind is in the header - need to install via cli but having issues -->
<?php 
	include "./src/global/header.php"; 

$connect = mysqli_connect(
	"db", 
	"php_docker",
	"password",
	"php_docker"
);

$table_name = "main";

$query = ("SELECT * FROM $table_name");

$response = mysqli_query($connect, $query);

echo("<strong>$table_name:</strong>");
while($i = mysqli_fetch_assoc($response)){
	echo("<p>".$i["name"]."</p>");
}

