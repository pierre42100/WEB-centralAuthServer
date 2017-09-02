<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Account model
 *
 * @author Pierre HUBERT
 */

class Account extends CI_Model {


	/**
	 * Check wether a user is signed in or not
	 *
	 * @return bool TRUE if signed in
	 */
	public function signed_in() : bool {
		return false;
	}

}