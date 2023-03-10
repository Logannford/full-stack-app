<?php
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

//open to the end of time