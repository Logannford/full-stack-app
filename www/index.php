<!-- the cdn for the tailwind is in the header - need to install via cli but having issues -->
<?php 
	/*
		Lets do some writing from random data api to sql here
		url - "https://random-data-api.com/api/users/random_user?size=1" NO API KEY NEEDED (thx random data api) 
	*/
	//just adds the cdn globally (im lazy)
	include "./src/global/header.php"; 

	//including everything in the clases folder
	foreach(glob("./src/classes/*.php") as $filename)
		include $filename;
	?>
	<div class="flex gap-x-6">
		<?php
			//create a new object of the DbConfig class
			$database = new DbConfig();

			//lets make these methods of a class extending DbConfig - doing this for now
			//select ALL from the main table
			$sql = "SELECT * FROM main";
			$result = mysqli_query($database->connection, $sql);

			//if we get no result from the query, then an error has occurred
			if(!$result)
				die();
			
			while($row = mysqli_fetch_assoc($result))
			//simply output all of the values in these rows
				echo('ID: ' . $row["id"] . ' Name: ' . $row["name"] . '<br>');
			
			/* 
				Free up the memory associated with the result
				Failing to free the result set can cause memory leaks
			*/
			mysqli_free_result($result);	

			//close the connection to the database - 
			//needed as many open connections to the db can slow down site speed
			mysqli_close($database->connection);

			//setting up the query
			$select_all_test = new SqlQuery();
			
			//using the 'select' method and passing in 'SELECT * FROM main"
			$data = $select_all_test->select("all", "main");
			//now we have the data as an array
			var_dump($data);
		?>
	</div>

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
		url: "https://random-data-api.com/api/users/random_user?size=0",
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

