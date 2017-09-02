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

		//Prepare page return
		$page_src = "";

		//Load signup form
		$page_src .= $this->load->view("signup/v_signup", array(
			
			//Login ticket
			"login_ticket" => $login_ticket,

		), true);

		//Load page structure
		$this->display_page("Signup", array(), array(), $page_src);
	}


}