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

		//Prepare page return
		$page_src = "";	

		//Load page structure
		$this->display_page("Login", array(), array(), $page_src);
	}

}