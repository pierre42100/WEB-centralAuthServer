<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Account model
 *
 * @author Pierre HUBERT
 */

class Account extends CI_Model {

	/**
	 * User session variables
	 *
	 * @var string
	 */
	private $user_sess_var = "central_auth_user";

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
		
		//Check if the user session variable exist or not
		if(!isset($_SESSION[$this->user_sess_var]))
			return false;

		//Check if it is an array
		if(!is_array($_SESSION[$this->user_sess_var]))
			return false;

		//Check if it is an empty array
		if(count($_SESSION[$this->user_sess_var]) < 1)
			return false;

		//Else user is logged in
		return true;

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
	 * Try to sign in user
	 *
	 * @param string $email The email address to search
	 * @param string $password The password associated to the email
	 * @return bool TRUE in case of success, false else
	 */
	public function sign_in(string $email, string $password){

		//First, check if the mail exist in the database
		if(!$this->exists($email))
			return false; //Email address not found

		//Retrieve user informations
		$query_result = $this->db->get_where("users", array("email" => $email));

		//Process results
		foreach($query_result->result() as $user_infos){

			//Compare the two passwords
			if(!$this->compare_passwords($user_infos->password, $password))
				//Password are not the same
				return false;

			//The user can be logged in
			$_SESSION[$this->user_sess_var] = array(
				"id" => $user_infos->ID,
				"email" => $user_infos->email,
				"name" => $user_infos->name,
				"creation_time" => $user_infos->creation_time,
			);

			//Login successfull
			return true;

		}

		//User couldn't be retrieved
		return false;
	}

	/**
	 * Get current user informations
	 *
	 * @return array $infos Informations about the user
	 */
	public function get_infos() : array {

		return $_SESSION[$this->user_sess_var];

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

	/**
	 * Compare a hashed password with a not hashed one
	 *
	 * @param string $hashed_password The hashed password to check
	 * @param string $password The other password (not hashed)
	 * @return bool TRUE if the passwords are the same
	 */
	private function compare_passwords(string $hashed_password, string $password) : bool {

		//Verity passwords
		return password_verify($password, $hashed_password);

	}

}