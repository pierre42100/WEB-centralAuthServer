<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Account model
 *
 * @author Pierre HUBERT
 */

class Account extends CI_Model {

	/**
	 * Public constructor
	 */
	public function __construct(){

		//Model constructor
		parent::__construct();

		//Check for session variable
		if(!isset($_SESSION))
			show_error("Session system must be enabled for account controller !");

	}

	/**
	 * Check wether a user is signed in or not
	 *
	 * @return bool TRUE if signed in
	 */
	public function signed_in() : bool {
		return false;
	}

	/**
	 * Check if an account with a specified email address exists or not
	 *
	 * @param string $email The email of the account to check
	 * @return bool TRUE if an account exist / false else
	 */
	public function exists(string $email) : bool {

		//Perform a request on the database
		$this->db->where("email", $email);
		$this->db->from("users");
		return $this->db->count_all_results() > 0;

	}

	/**
	 * Create an account
	 *
	 * @param string $name The name of the user
	 * @param string $email The email of the user
	 * @param string $password User password
	 * @return bool TRUE in case of sucess
	 */
	public function create(string $name, string $email, string $password) : bool {

		//Crypt password
		$crypted_password = $this->crypt_password($password);


		//Insert user in database
		return $this->db->insert("users", array(
			"name" => $name,
			"email" => $email,
			"password" => $crypted_password,
			"creation_time" => time()
		));


	}

	/**
	 * Crypt a user password
	 *
	 * @param string $password The password to crypt
	 * @return string Crypted password
	 */
	private function crypt_password(string $password) : string {
		return password_hash($password, PASSWORD_DEFAULT);
	}

}