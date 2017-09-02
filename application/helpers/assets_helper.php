<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Assets helper
 *
 * @author Pierre HUBERT
 */

if(!function_exists('path_assets')){

	/**
	 * Returns the path to an asset
	 *
	 * @param str $file The file to give the path to
	 * @return str The full URL to asset
	 */
	function path_assets(string $file = "") : string {
		return base_url()."assets/".$file;
	}

}