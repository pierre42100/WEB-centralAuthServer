<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authorization model
 *
 * @author Pierre HUBERT
 */

class Authorizations extends CI_Model {

	/**
	 * Check if an application is authorized by a user or not
	 *
	 * @param int $user_id The ID of the user to check
	 * @param in $app_id The ID of the applicaiton to check
	 * @return bool TRUE if the application is authorized to access
	 * user informations
	 */
	public function is_authorized(int $user_id, int $app_id) : bool {

		//Perform a request on the database
		$this->db->where("id_user", $user_id);
		$this->db->where("id_application", $app_id);
		$this->db->from("authorizations");
		return $this->db->count_all_results() > 0;

	}


}