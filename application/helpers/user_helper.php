<?php
/**
 * User helper
 *
 * @author Pierre HUBERT
 */

if(!function_exists("current_user_infos")){

	/**
	 * Return informations about currently signed in user
	 *
	 * @return array Informations about the user
	 */
	function current_user_infos() : array {

		return get_instance()->account->infos_current();

	}

}