<?php
/**
 * Application helper
 *
 * @author Pierre HUBERT
 */

if(!function_exists("app_name")){

	/**
	 * Returns the name of the application
	 *
	 * @return string The name of the application
	 */
	function app_name() : string {
		return get_instance()->config->item("app_name");
	}

}