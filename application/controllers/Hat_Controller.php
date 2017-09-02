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

		//Return view file of the page structure
		$this->load->view("common/v_page_structure", array(

			"page_title" => $page_title,
			"css_files" => $css_files,
			"js_files" => $js_files,
			"page_src" => $page_src,

		));

	}

}