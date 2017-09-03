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
	 * Signout any currently signed in user
	 *
	 * @return bool TRUE for a sucess
	 */
	public function sign_out() : bool{
		
		//Check if there is anybody to sign out
		if(!isset($_SESSION[$this->user_sess_var]))
			return FALSE;

		//Sign out user
		unset($_SESSION[$this->user_sess_var]);

		//Success
		return TRUE;
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
				//Passwords are not the same
				return false;

			//The user can be logged in
			//Save user informations in the session
			$this->set_session_infos($user_infos);
			

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
	public function infos_current() : array {
		return $_SESSION[$this->user_sess_var];
	}

	/**
	 * Get current user ID
	 *
	 * @return int ID of the user
	 */
	public function get_current_id() : int {
		return $_SESSION[$this->user_sess_var]['id'];
	}

	/**
	 * Get informations about a user specified by its ID
	 *
	 * @param int $id The ID of the user to perform the search on
	 * @return stdClass Informations about the user
	 */
	public function infos_by_id(int $id) : stdClass{

		//Retrieve user informations based on user ID
		$query_result = $this->db->get_where("users", array("ID" => $id));

		//Process results
		foreach($query_result->result() as $user_infos){

			//Return result
			return $user_infos;

		}

		//User couldn't be retrieved
		return false;
	}

	/**
	 * Check if a specified password match with a specified account ID
	 *
	 * @param int $user_id The ID of the user to check
	 * @param string $password The password to check
	 * @return bool TRUE if the password is valid
	 */
	public function check_password(int $user_id, string $password) : bool {

		//Retrieve user informations based on user ID
		$user_infos = $this->infos_by_id($user_id);

		//Compare the two passwords
		if(!$this->compare_passwords($user_infos->password, $password))
			//Passwords are not the same
			return false;

		//The password is correct
		return true;

	}

	/**
	 * Update a user informations
	 *
	 * @param int $user_id The ID of the user to update
	 * @param string $new_name The new name of the user
	 * @param string $new_password The new password of the user ("0" = keep current password)
	 * @return bool TRUE in case of success
	 */
	public function update_infos(int $user_id, string $new_name, string $new_password) : bool {

		//Prepare reuest
		$changes = array("name" => $new_name);

		//Update password if required
		if($new_password !== "0")
			$changes['password'] = $this->crypt_password($new_password);

		//Set update conditions
		$conditions = "ID = ".floor($user_id*1);

		//Try to perform update
		return $this->db->update("users", $changes, $conditions);

	}

	/**
	 * Update informations about a signed in user
	 */
	public function update_signed_in_infos(){
		//Check if user is signed in or not
		if(!$this->signed_in())
			return;

		//Retrieve new informations about the user
		$current_infos = $this->infos_current();
		$new_infos = $this->infos_by_id($current_infos['id']);

		//Save new informations
		$this->set_session_infos($new_infos);
	}

	/**
	 * Save user informations in user variable (sign in proof)
	 *
	 * @param stdClass $user_infos Informations about the user
	 */
	private function set_session_infos(stdClass $user_infos){

		$_SESSION[$this->user_sess_var] = array(
			"id" => $user_infos->ID,
			"email" => $user_infos->email,
			"name" => $user_infos->name,
			"creation_time" => $user_infos->creation_time,
		);

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