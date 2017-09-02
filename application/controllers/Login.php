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

		//Prepare page return
		$page_src = "";

		//Load login form
		$page_src .= $this->load->view("login/v_login", array(
			
			//Login ticket
			"login_ticket" => $login_ticket,

		), true);

		//Load page structure
		$this->display_page("Login", array(), array(), $page_src);
	}

}