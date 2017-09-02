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

		//Check if user asked to sign out
		if($this->input->get("signout") !== NULL)
			//Disconnect user
			$this->account->sign_out();

		//Check if user is signed in or not
		if(!$this->account->signed_in())
			redirect("login?login_ticket=".$login_ticket);

		//Prepare page return
		$page_src = "";

		//Include specific CSS files
		$css_files = array(
			path_css_assets("common/signed_in_box"),
		);

		//Show default box
		$box_src = $this->load->view("home/v_welcome", array("login_ticket" => $login_ticket), true);


		//Include home box
		$page_src .= $this->load->view("common/v_signed_in_box", array(

			//Generic informations
			"login_ticket" => $login_ticket,

			//Box content
			"box_content" => $box_src,

		), TRUE);

		//Load page structure
		$this->display_page("Home", $css_files, array(), $page_src);

	}

}