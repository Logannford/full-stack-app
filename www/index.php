<!-- the cdn for the tailwind is in the header - need to install via cli but having issues -->
<?php 
	/*
		Lets do some writing from random data api to sql here
		url - "https://random-data-api.com/api/users/random_user?size=1" NO API KEY NEEDED (thx random data api) 
	*/
	//just adds the cdn globally (im lazy)
	include "./src/global/header.php"; 
	//lets do some connection tests first

	//if no connection go bye bye
	if(!$connect)
		die();

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
		echo("<p>".$i["dob"]."</p>");
		echo("<p>".$i["date_created"]."</p>");
	}
?>


<!-- 
	on load the mounted method will run 
	'v-html' will output the test.php in html
-->
<div @vue:mounted="mounted()" class="">
	<div v-html="phpData" class=""></div>	
</div>

<script type="module">
	import { createApp } from 'https://unpkg.com/petite-vue?module'
	createApp({
		/** data properties */
		url: "https://random-data-api.com/api/users/random_user?size=1",
		firstName: "",
		person: {},
		dob: "",
		phpData: "",

		mounted(){
			fetch(this.url, {
				method: "GET",
				credentials: "same-origin",
				headers: {
					"content-type": "application/json"
				}
			})

			//turn the response into json so we can use it
			.then((response) => {
				return response.json()
			})

			//once its turned into json - 
			.then((data) => {
				//create a person object
				this.person = data;
				//firstname = 
				this.firstName = this.person[0].first_name;
				//dob = 
				this.dob = this.person[0].date_of_birth;
				
				//writing to the php file - using the site url, and passing in the values
				//we want in the db
				const phpFile = `http://localhost:8000/test.php?first_name=${this.firstName}&dob=${this.dob}`;
				return fetch(phpFile, {
					method: "GET",
					headers: {
					credentials: "same-origin"
					}
				});
				//once we have done then, turn the response into text
				})
				.then((phpResponse) => {
				return phpResponse.text();
				})
				.then((phpData) => {
				this.phpData = phpData;
				})
				//error any issues we have
				.catch((error) => {
				console.error(error);
				});
		}
	}).mount()
</script>

