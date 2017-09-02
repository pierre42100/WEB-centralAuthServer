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

		//Check for client informations
		if($this->input->post("client_id") === NULL ||
			$this->input->post("client_secret") === NULL)

			//This is an error
			restserver_error("Please specify client credentials !", 401);

		//Extract informations
		$client_id = $this->input->post("client_id");
		$client_secret = $this->input->post("client_secret");

		//Check application credentials & get application id
		$app_id = $this->applications->get_id_from_credentials($client_id, $client_secret);

		//Check for errors
		if($app_id === 0)
			restserver_error("Couldn't verify application credentials !", 401);

		exit("OK");

	}

}