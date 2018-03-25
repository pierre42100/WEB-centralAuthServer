<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applications access controller
 *
 * @author Pierre HUBERT
 */

//Include hat controller
require_once(__DIR__."/Hat_Controller.php");

class Access extends Hat_Controller {

	/**
	 * Authorize an application
	 */
	public function authorize(){
		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//Check if user is signed in or not
		if(!$this->account->signed_in())
			redirect("login?login_ticket=".$login_ticket);

		//Get current user ID
		$user_id = $this->account->get_current_id();

		//Redirect to home page if there isn't any ticket
		if($login_ticket === "NONE")
			redirect("?login_ticket=".$login_ticket);

		//Check if specified token exists
		if(!$this->login_tickets->exists($login_ticket)){
			$error_msg = "The login request seems to be invalid !";

			//Reset token
			$login_ticket = "NONE";
		}

		//Get informations about the login ticket
		if(!isset($error_msg)){
			$ticket_infos = $this->login_tickets->get_infos($login_ticket);

			//Check if everything went good
			if(count($ticket_infos) === 0)
				$error_msg = "Couldn't retrieve required informations to log you in !";
		}

		//Check if login ticket is already allocated to another user ID
		if(!isset($error_msg)){
			if($ticket_infos['user_id'] !== "0" && $ticket_infos['user_id'] !== (string) $user_id)
				$error_msg = "It seems that your login ticket has been used by another user...";
		}


		//Check if an error occured
		if(isset($error_msg)){
			$box_src = $this->load->view("access/v_error", array("error_msg" => $error_msg), true);
		}

		else {

			//Get informations about the application
			$app_infos = $this->applications->get_infos($ticket_infos['application_id']);

			//Check if the user has made a the choice to authorize or not the application
			if($this->input->post("authorize") !== NULL){

				//Check if the application was authorized or not
				if($this->input->post("authorize") === "yes"){

					//We can authorize the application
					$this->authorizations->authorize_app($user_id, $ticket_infos['application_id']);

				}
				else {
					//Request was denied
					//Delete login request
					$this->login_tickets->delete($login_ticket);

					//Redirect user to the application
					$redirect_url = str_replace("%AUTHORIZATION%", "CANCEL", $ticket_infos['redirect_url']);

					//Required box is redirection box
					$box_src = $this->load->view("access/v_redirect", array(
						"app_infos" => $app_infos, 
						"redirect_url" => $redirect_url
					), true);
				}

			}

			//Continue only if the request was not denied
			if(!isset($box_src)){
				//Check if user authorized the application or not
				if($this->authorizations->is_authorized($user_id, $ticket_infos['application_id'])){

					//Update ticket with user ID
					$this->login_tickets->set_user_id($login_ticket, $user_id);
					$this->login_tickets->set_validated($login_ticket);

					//Redirect user
					$redirect_url = str_replace("%AUTHORIZATION%", $ticket_infos['authorization_token'], $ticket_infos['redirect_url']);

					//Required box is redirection box
					$box_src = $this->load->view("access/v_redirect", array(
						"app_infos" => $app_infos, 
						"redirect_url" => $redirect_url
					), true);

				}

				//Else we offer user to do so
				else {
					//Load authorize box
					$box_src = $this->load->view("access/v_authorize_form", array(
						"app_infos" => $app_infos,
						"login_ticket" => $login_ticket,
					), true);
				}
			}

		}

		//Include specific CSS files
		$css_files = array(
			path_css_assets("common/signed_in_box"),
		);

		//Include main logged in box
		$page_src = $this->load->view("common/v_signed_in_box", array(

			//Generic informations
			"login_ticket" => $login_ticket,

			//Box content
			"box_content" => $box_src,

		), TRUE);

		//Load page structure
		$this->display_page("Authorize application", $css_files, array(), $page_src);
	}

	/**
	 * Display the list of authorized accesses
	 */
	public function list(){

		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//Get the list of authorized apps
		$apps_list = $this->authorizations->list($this->account->get_current_id());

		$box_src = $this->load->view("access/v_list", array(
			"list" => $apps_list
		), true);

		//Include specific CSS files
		$css_files = array(
			path_css_assets("common/signed_in_box"),
		);

		//Include logged in page
		$page_src = $this->load->view("common/v_signed_in_box", array(

			//Generic informations
			"login_ticket" => $login_ticket,

			//Box content
			"box_content" => $box_src,

		), TRUE);

		//Load page structure
		$this->display_page("Access List", $css_files, array(), $page_src);
	}

}