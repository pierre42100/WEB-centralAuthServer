<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applications model
 *
 * @author Pierre HUBERT
 */

class Applications extends CI_Model {

	/**
	 * Get an application ID from given credentials
	 *
	 * @param string $client_id The client ID
	 * @param string $client_secret The client secret
	 * @return int Application ID (0 for error)
	 */
	public function get_id_from_credentials(string $client_id, string $client_secret) : int{

		//Perform a database request
		$result = $this->db->where("client_id", $client_id)
			->where("client_secret", $client_secret)
			->get("applications", 1, 0);

		
		//Process results
		foreach($result->result() as $app_infos){
			return $app_infos->id;
		}

		//Client ID was not found
		return 0;
	}


}