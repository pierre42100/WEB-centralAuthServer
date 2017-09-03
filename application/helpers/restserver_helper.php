<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RestServer helper
 *
 * @author Pierre HUBERT
 */

if(!function_exists("restserver_response")){

	/**
	 * Returns a restserver response
	 *
	 * @param mixed $response The response content
	 * @param int $code Response code (200, 400, ...)
	 * @param bool exit Exit the script when response is returned
	 */
	function restserver_response($response, int $code = 200, bool $exit = TRUE){

		//Check if response is an array
		if(is_array($response))
			$response = json_encode($response);

		//Return content type
		header("Content-Type: application/json");

		//Response code
		http_response_code($code);

		//Return response
		echo $response;

		//Quit application (if required)
		if($exit)
			exit();

	}

}


if(!function_exists("restserver_error")){

	/**
	 * Returns a restserver error
	 *
	 * @param string $error The error message
	 * @param int $code Response code (200, 400, ...)
	 */
	function restserver_error(string $error, int $code = 400){

		//Return response
		restserver_response(
			array(
				"error" => array(
					"message" => $error,
					"code" => $code,
				)
			)
			, $code
		);
	}

}