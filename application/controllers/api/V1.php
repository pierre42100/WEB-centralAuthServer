<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * First version of the centralAuth system
 *
 * @author Pierre HUBERT
 */

class V1 extends CI_Controller {

	/**
	 * Create a new ticket
	 */
	public function create_ticket(){

		//Check application credentials & get application id
		$app_id = $this->check_client_credentials();
		

		//Check for other informations
		if($this->input->post("redirect_url") === NULL)

			//This is an error
			restserver_error("Please specify a redirect url !", 400);

		//Extract informations
		$redirect_url = $this->input->post("redirect_url");

		//Check redirect url validity
		if(!preg_match("/%AUTHORIZATION%/", $redirect_url))
			restserver_error("Please specify a valid redirect url !", 401);

		//Generate login token
		$ticket = $this->login_tickets->create($app_id, $redirect_url);

		//Check for error
		if(strlen($ticket) < 5)
			restserver_error("Couldn't create login ticket !", 500);

		//Prepare result return
		$result = array(
			"login_ticket" => $ticket,
			"login_url" => base_url()."?login_ticket=".$ticket,
		);

		//Return result
		$ticket = restserver_response($result, 200, false);

	}

	/**
	 * Retrieve user informations
	 */
	public function get_user_infos(){

		//Check application credentials & get application id
		$app_id = $this->check_client_credentials();


		//Check if login token & authorization are included with the request
		if($this->input->post("login_ticket") === NULL ||
			$this->input->post("authorization_token") === NULL)
			//This is an error
			restserver_error("Please specify login ticket and authorization token !", 401);

		//Extract informations
		$login_ticket = $this->input->post("login_ticket");
		$authorization_token = $this->input->post("authorization_token");

		//Check if login ticket exists or not
		if(!$this->login_tickets->exists($login_ticket))
			restserver_error("Specified login ticket couldn't be found !", 401);


		//Fetch login ticket informations
		$infos_ticket = $this->login_tickets->get_infos($login_ticket);

		//Check for errors
		if(count($infos_ticket) < 1)
			restserver_error("Couldn't retrieve informations about login ticket !", 500);

		//Check if the authorization token is valid
		if($infos_ticket['authorization_token'] !== $authorization_token)
			restserver_error("Specified authorization token is invalid !", 401);

		//Check if the ticket was validated
		if($infos_ticket['user_id'] === "0")
			restserver_error("The login ticket is not validated by user !", 401);

		//Retrieve informations about the user
		$user_infos = $this->account->infos_by_id($infos_ticket['user_id']);

		//Prepare return
		$data = array(
			"user_infos" => array(
				"id" => $user_infos->ID,
				"name" => $user_infos->name,
				"mail" => $user_infos->email,
			),
		);


		//Return result
		restserver_response($data, 200, FALSE);

	}

	/**
	 * Check client credentials
	 *
	 * @return int The ID of the client application
	 */
	private function check_client_credentials() : int {

		//Check for client informations
		if($this->input->post("client_id") === NULL ||
			$this->input->post("client_secret") === NULL)

			//This is an error
			restserver_error("Please specify client credentials !", 401);


		//Extract informations
		$client_id = $this->input->post("client_id");
		$client_secret = $this->input->post("client_secret");

		//Fetch client id
		$app_id = $this->applications->get_id_from_credentials($client_id, $client_secret);

		//Check for errors
		if($app_id === 0)
			restserver_error("Couldn't verify application credentials !", 401);

		//Return client ID
		return $app_id;

	}

}