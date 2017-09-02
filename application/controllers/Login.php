<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Login controller
 *
 * @author Pierre HUBERT
 */

//Include hat controller
require_once(__DIR__."/Hat_Controller.php");

class Login extends Hat_Controller {
	
	/**
	 * Login page of the service
	 */
	public function index(){

		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//Check if form was submitted
		if($this->input->post("inputEmail") !== NULL
			&& $this->input->post("inputPassword") !== NULL){

			//Extract fields
			$email = $this->input->post("inputEmail");
			$password = $this->input->post("inputPassword");

			//Check email address
			if(!filter_var($email, FILTER_VALIDATE_EMAIL))
				$error_msg = "Invalid email address !";

			//Check password
			if(strlen($password) < 5)
				$error_msg = "Invalid password !";

			//Try to login user
			if(!$this->account->sign_in($email, $password))
				$error_msg = "Couldn't log you in with the supplied informations !";

			//Else user is signed in
			else
				redirect("?login_ticket=".$login_ticket);
			
		}

		//Prepare page return
		$page_src = "";

		//Load login form
		$page_src .= $this->load->view("login/v_login", array(
			
			//Login ticket
			"login_ticket" => $login_ticket,

			//Default values
			"default_mail" => isset($email) ? $email : "",

			//Error message
			"error_msg" => isset($error_msg) ? $error_msg : false,

		), true);

		//Load page structure
		$this->display_page("Login", array(), array(), $page_src);
	}

}