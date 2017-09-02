<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Signup controller
 *
 * @author Pierre HUBERT
 */

//Include hat controller
require_once(__DIR__."/Hat_Controller.php");

class Signup extends Hat_Controller {

	/**
	 * Main signup method
	 */
	public function index(){

		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//Check if an account creation request has been made
		if(
			$this->input->post("inputName") != NULL &&
			$this->input->post("inputEmail") != NULL &&
			$this->input->post("inputPassword") != NULL &&
			$this->input->post("confirmPassword") != NULL
		){

			//Extract informations
			$name = $this->input->post("inputName");
			$email = $this->input->post("inputEmail");
			$password = $this->input->post("inputPassword");
			$confirmPassword = $this->input->post("confirmPassword");

			//Check passwords are similar
			if($password !== $confirmPassword)
				$error_msg = "Passwords are not the same !";

			//Check password
			if(strlen($password) < 5)
				$error_msg = "Password too small !";

			//Check email
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				$error_msg = "Invalid email address !";

			//Check name
			if(strlen($name) < 5)
				$error_msg = "Specified name too short !";

			//Continue in case of success
			if(!isset($error_msg)){
				//Check if an account exists or not
				if($this->account->exists($email))
					$error_msg = "An account with the specified email address already exists !";
			}

			//Continue only in case of success
			if(!isset($error_msg)){
				//Create the account
				if(!$this->account->create($name, $email, $password))
					$error_msg = "An error occured while trying to create an account !";
				else
					$account_created = true;
			}

		}


		//Prepare page return
		$page_src = "";

		//Load signup form
		$page_src .= $this->load->view(

			//View file
			isset($account_created)  ? "signup/v_signup_success" : "signup/v_signup", 

			//View data
			array(
			
				//Login ticket
				"login_ticket" => $login_ticket,

				//Default fields
				"default_name" => isset($name) ? $name : "",
				"default_email" => isset($email) ? $email : "",

				//Check for error message
				"error_msg" => isset($error_msg) ? $error_msg : false,

			), 

			//Do not return result to output
			true
		);

		//Load page structure
		$this->display_page("Signup", array(), array(), $page_src);
	}


}