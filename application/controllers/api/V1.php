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


	}

}