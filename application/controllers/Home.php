<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home controller
 *
 * @author Pierre HUBERT
 */

//Include hat controller
require_once(__DIR__."/Hat_Controller.php");

class Home extends Hat_Controller {

	/**
	 * Index page of the project
	 *
	 * @url http://project/home
	 */
	public function index() {

		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//Check if user is signed in or not
		if(!$this->account->signed_in())
			redirect("login?login_ticket=".$login_ticket);

	}

}