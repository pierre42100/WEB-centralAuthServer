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


	/**
	 * Retrieve informations about an application
	 *
	 * @param int $app_id The ID of the application
	 * @return array Informations about the application
	 */
	public function get_infos(int $app_id) : array {

		//Query the database
		$result = $this->db->where("id", $app_id)
					->get("applications");

		//Check for result
		$infos = $result->result();

		//Check for errors
		if(count($infos) === 0)
			return array(); //No result found

		//Process & return result
		return array(
			"name" => $infos[0]->name,
			"description" => $infos[0]->description,
			"client_id" => $infos[0]->client_id,
			"client_secret" => $infos[0]->client_secret,
		);

	}

}