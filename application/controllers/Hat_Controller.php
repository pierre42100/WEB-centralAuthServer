<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hat controller of the pages of the project
 *
 * @author Pierre HUBERT
 */

class Hat_Controller extends CI_Controller {

	/**
	 * Display a page
	 *
	 * @param string $page_title The title of the page
	 * @param array $css_files List of CSS files to include at the begining of the page
	 * @param array $js_files List of javascript files to include at the end of the page
	 * @param string $page_src The content of the page to display (source code)
	 * @return void
	 */
	protected function display_page(string $page_title, array $css_files, array $js_files, string $page_src){

		//Add default CSS files to the css files list
		$css_files = array_merge(array(

			//Bootstrap
			path_vendor("bootstrap/css/bootstrap.min.css"),

			//Application stylesheet
			path_css_assets("main"),

		), $css_files);

		//Add default JS files to js files list
		$js_files = array_merge(
			//First files
			array(
				path_vendor("bootstrap/js/bootstrap.min.js"),
			), 

			//Default files
			$js_files, 

			//Last files
			array(
				path_vendor("ie10-viewport-bug-workaround.js"), //Need to be the last included file for optimization
			)
		);

		//Return view file of the page structure
		$this->load->view("common/v_page_structure", array(

			"page_title" => $page_title,
			"css_files" => $css_files,
			"js_files" => $js_files,
			"page_src" => $page_src,

		));

	}

}