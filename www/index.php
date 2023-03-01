<!-- the cdn for the tailwind is in the header - need to install via cli but having issues -->
<?php 

/*
	Lets do some writing from random data api to sql here
	url - "https://random-data-api.com/api/users/random_user?size=1" NO API KEY NEEDED (thx random data api) 
*/
	//just adds the cdn globally (im lazy)
	include "./src/global/header.php"; 
	//lets do some connection tests first
	$connect = mysqli_connect(
		"db", 
		"php_docker",
		"password",
		"php_docker"
	);

	//easier manipulate in the future
	$table_name = "main";
	//getting all of the values from the table with the name "main"
	$query = ("SELECT * FROM $table_name");
	//getting the response
	$response = mysqli_query($connect, $query);
	//also ew no thanks no likey 
	echo("<strong>$table_name:</strong>");
	while($i = mysqli_fetch_assoc($response)){
		echo("<p>".$i["name"]."</p>");
	}
?>

<div @vue:mounted="mounted()" class="">

</div>

<script type="module">
	import { createApp } from 'https://unpkg.com/petite-vue?module'
	createApp({
		/** data properties */
		firstName: "",

		async mounted(){
			const url = "https://random-data-api.com/api/users/random_user?size=1";

			const response = await fetch(url, {
				method: "GET",
				cors: "cors",
				credentials: "same-origin",
				headers: {
					"content-type": "application/json"
				}
			})

			const person = await response.json();
			this.firstName = person[0].first_name

			console.log(this.firstName);
		}	
	}).mount()
</script>

