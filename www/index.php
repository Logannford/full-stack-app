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
			//$args for the select query
			$args = [
				"select"		=> "all",
				"table"			=> "main"
			];
			//setting up the query
			$select_all_test = new SqlQuery();

			//using the 'select' method and passing in 'SELECT * FROM main"
			$data = $select_all_test->select($args);
			
			var_dump($data);
		?>
	</div>

	<div class="w-full flex justify-center mt-20">
		<form 
			class="flex flex-col"
			@submit.prevent
			@submit="signUpFormDetails()"
		>
			<label for="name">Name</label>
			<input 
				class="border border-black" 
				type="text" 
				id="name"
				v-model="signUpName"
			>

			<button type="submit" class="border border-black rounded-md mt-4">
				Submit
			</button>
		</form>
		<div v-if="loading" class="border border-black w-5 h-5 rounded-full"></div>
	</div>

<!-- 
	on load the mounted method will run 
	'v-html' will output the test.php in html
-->
<div @vue:mounted="mounted()" class="">
	<div v-html="phpData" class=""></div>	
</div>

<div v-html="auth"></div>

<script type="module">
	import { createApp } from 'https://unpkg.com/petite-vue?module'
	createApp({
		/** data properties */
		randomDataUrl: "https://random-data-api.com/api/users/random_user?size=1", 
		firstName: "",
		person: {},
		dob: "",
		phpData: "",

		//just set the url globally
		url: "http://localhost:8000",

		//getting the name from sign up
		signUpName: "",
		loading: false,
		auth: "",

		/* methods */
		mounted(){
			fetch(this.randomDataUrl, {
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
				
				/*
					writing to the php file - using the site url, and passing in the values
					we want in the db
				*/
				const phpFile = `${this.url}/test.php?function=test&first_name=${this.firstName}&dob=${this.dob}`;
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
			},

			signUpFormDetails(){
				const signUpUrl = `${this.url}/test.php?function=add_new_user_to_db&username=${this.signUpName}`;

				fetch(signUpUrl, {
					method: "GET",
					headers: {
						credentials: "same-origin"
					}
				})

				.then((response) => {
					if(response.ok)
						return response.text();
				})

				.then((auth) => {
					this.auth = auth;
				})
			}
	}).mount()
</script>

