<?php
/**
 * Protection helper
 *
 * I didn't choose the name security because it would have overwritten
 * the default security helper that comes with CodeIgniter
 *
 * @author Pierre HUBERT
 */


if(!function_exists("csrf_input_field")){

	/**
	 * Display CSRF hidden input field
	 */
	function csrf_input_field(){

		//Get CSRF field name and hash
		$name = get_instance()->security->get_csrf_token_name();
		$hash = get_instance()->security->get_csrf_hash();

		//Return the input
		echo "<input type='hidden' name='".$name."' value='".$hash."' />";

	}
}