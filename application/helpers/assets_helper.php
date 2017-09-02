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

if(!function_exists('path_vendor')){

	/**
	 * Returns the path to a vendor asset
	 *
	 * @param str $file The file to give the path to
	 * @return str The full URL to asset
	 */
	function path_vendor(string $file = "") : string {
		return path_assets("vendor/".$file);
	}

}

if(!function_exists('path_css_assets')){

	/**
	 * Returns the path to a CSS asset file
	 *
	 * @param str $file The file to give the path to
	 * @return str The full URL to asset
	 */
	function path_css_assets(string $file) : string {
		return path_assets("css/".$file.".css");
	}

}

if(!function_exists('path_js_assets')){

	/**
	 * Returns the path to a JS asset file
	 *
	 * @param str $file The file to give the path to
	 * @return str The full URL to asset
	 */
	function path_js_assets(string $file) : string {
		return path_assets("js/".$file.".js");
	}

}