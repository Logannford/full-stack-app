<?php
	/**
	 * Class to make an api request using cURL
	 * 
	 * Simply pass in the url, and a cURL request will give you back 
	 * the data in json format - TODO: make more params to pass in
	 * to alter the return format
	 * 
	 * Currently a class to preform simple curl request 
	 * in the future, use abstraction and inheritance to extend this class
	 * for other use cases
	 */
	class ApiRequest{
		protected $api_url;

		public function __construct(string $api_url){
			//we need so if not bye bye
			if(!$api_url)
				return;
			//setters
			$this->api_url = $api_url;
		}

		function make_request(){
			if(!$this->api_url)	
				return;
			
			//initialize a cURL session
			$curl_request = curl_init();

			if(!$curl_request)
				return;
			//setting the url we want to fetch from
			curl_setopt($curl_request, CURLOPT_URL, $this->api_url);
			/**
			 * setting the CURLOPT_RETURNTRANSFER to 1, telling the cURL to return the response 
			 * as a string and not outputting it directly
			 */
			curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
			//actually executing the cURL request and converts from a string to json 
			$response = json_decode(curl_exec($curl_request), true);
			//this closes the cURL request to free up system storage
			curl_close($curl_request);

			return $response;
		}
	}