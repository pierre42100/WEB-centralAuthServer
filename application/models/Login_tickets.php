<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login tickets management models
 *
 * @author Pierre HUBERT
 */

class Login_tickets extends CI_Model {

	/**
	 * Create a new ticket for an application
	 *
	 * @param int $app_id The ID of the target app
	 * @param string $redirect_url The URL where user will be redirected once login succeeded
	 * @return string The ticket token
	 */
 	public function create(int $app_id, string $redirect_url) : string {

 		//Generate a ticket token
 		$ticket_token = random_string("alnum", $this->config->item('length_login_ticket'));

 		//Insert the ticket in the database
 		$this->db->insert("login_tickets", array(
 			"creation_time" => time(),
 			"ticket_token" => $ticket_token,
 			"redirect_url" => $redirect_url,
 			"application_id" => $app_id,
 		));

 		//Return created login token
 		return $ticket_token;

 	}

}