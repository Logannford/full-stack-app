<?php
	
	if(class_exists("SqlQuery"))
		require_once("./src/classes/class-query.php");
/**
 * @param string $string
 * 
 * Takes in a string, strips it off all malicious tags which could cause 
 * SQL injection
 */
function sanitize_string(string $string) {

	if(is_null($string))
		return;
		
	//check if the string contains the special characters
	if(!preg_match("/[<>\/\'$]/", $string))
        // If not, capitalize the first letter and return
        return $string;
    
    // Otherwise, remove the special characters and capitalize the first letter
	$string = strtolower(str_replace(["<", ">", "/", "\'", "$"], '', $string));
	return ucfirst($string);
}

/**
 * Will try to make a new username until it finds one not in the db
 * 
 */
function suggest_new_username(string $username){
    if(!$username)
        return;

    $username_checker = new SqlQuery();

    $valid_new_username = false;
	/**
	 * fine for now - eventually use this api - https://random-word-api.herokuapp.com/word?number=10
	 * and generate three new usernames
	 */
    while($valid_new_username == false){
        $new_username = "$username" . rand(0, 2000);

		$random_words = get_random_words();

		var_dump($random_words);

        $args = [
            "table_name"    => "users",
            "username"      => $new_username
        ];

        $username_exists = $username_checker->user_exists($args);

        if(array_key_exists("username", $username_exists)) 
            $valid_new_username = false;
        else {
            $valid_new_username = true;
            $username = $new_username;
        }
    }

    return $username;
}

/**
 * Function that will return 10 random words from the api
 * 
 */
function get_random_words(){

	//initialize a cURL session
	$curl_request = curl_init();

	if(!$curl_request)
		return;
	//setting the url we want to fetch from
	curl_setopt($curl_request, CURLOPT_URL, "https://random-word-api.herokuapp.com/word?number=10");
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

//open to the end of time