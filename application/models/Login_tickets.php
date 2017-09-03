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

		//Generate an authorization token
		$authorization_token = random_string("alnum", $this->config->item('length_authorization_token'));

		//Insert the ticket in the database
		$this->db->insert("login_tickets", array(
			"creation_time" => time(),
			"ticket_token" => $ticket_token,
			"authorization_token" => $authorization_token,
			"redirect_url" => $redirect_url,
			"application_id" => $app_id,
		));

		//Return created login token
		return $ticket_token;

	}

	/**
	 * Delete a login token
	 *
	 * @param string $login_token The token to delete
	 * @return bool TRUE in case of success
	 */
	public function delete(string $login_ticket) : bool {
		$this->db->where("ticket_token", $login_ticket);
		return $this->db->delete("login_tickets");
	}

	/**
	 * Check wether a login request exists or not
	 *
	 * @param string $login_ticket The login ticket to check
	 * @return bool TRUE if it exits
	 */
	public function exists(string $login_ticket) : bool {
		//Search in the database
		$this->db->where("ticket_token", $login_ticket);
		$this->db->from("login_tickets");
		return $this->db->count_all_results() > 0;
	}

	/**
	 * Retrieve informations about a login ticket
	 *
	 * @param string $login_ticket The ticket to get informations on
	 * @return array The informations about the ticket
	 *					Empty array in case of error
	 */
	public function get_infos(string $login_ticket) : array {

		//Get informations about the ticket in the database
		$result = $this->db->get_where("login_tickets", array("ticket_token" => $login_ticket));

		//Process informations
		$infos = $result->result();
		
		//Check for errors
		if(count($infos) === 0)
			return array(); //Login ticket not found


		//Return result
		return array(
			"creation_time" => $infos[0]->creation_time,
			"authorization_token" => $infos[0]->authorization_token,
			"redirect_url" => $infos[0]->redirect_url,
			"application_id" => $infos[0]->application_id,
			"user_id" => $infos[0]->user_id
		);
	}

	/**
	 * Set the user ID of a ticket
	 *
	 * @param string $login_token The login token to update
	 * @param int $user_id Target user ID
	 * @return bool TRUE for a success
	 */
	public function set_user_id(string $login_token, int $user_id) : bool {

		return $this->db->update(
			//Table
			"login_tickets", 

			//Editions
			array("user_id" => $user_id), 

			//Conditions
			array("ticket_token" => $login_token),

			//Limit
			1);

	}

}