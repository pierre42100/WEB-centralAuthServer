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
	 * @param int $app_id The ID of the applicaiton to check
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

	/**
	 * Authorize an application to access a user informations
	 *
	 * @param int $user_id The ID of the user who authorize
	 * @param int $app_id The ID of the application to authorize
	 * @return bool TRUE for a sucess
	 */
	public function authorize_app(int $user_id, int $app_id) : bool {

		//Insert the authorization in the database
		return $this->db->insert("authorizations", array(
			"id_user" => $user_id,
			"id_application" => $app_id,
			"time_add" => time(),
		));

	}


}