<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile management
 *
 * @author Pierre HUBERT
 */

//Include hat controller
require_once(__DIR__."/Hat_Controller.php");

class Profile extends Hat_Controller {


	/**
	 * Update profile
	 */
	public function update(){

		//Check for login ticket
		$login_ticket = isset($_GET['login_ticket']) ? urlencode($_GET['login_ticket']) : "NONE";

		//This page requires user to be signed in
		if(!$this->account->signed_in())
			redirect("login?login_ticket=".$login_ticket);

		//Get current user informations
		$user = current_user_infos();

		//Check if user informations have to be udpated or not
		if($this->input->post("inputName") !== NULL &&
			$this->input->post("oldPassword") !== NULL &&
			$this->input->post("newPassword") !== NULL &&
			$this->input->post("confirmNewPassword") !== NULL){

			//Extract fields
			$newName = $this->input->post("inputName");
			$oldPassword = $this->input->post("oldPassword");
			$newPassword = $this->input->post("newPassword");
			$confirmNewPassword = $this->input->post("confirmNewPassword");

			//Check new name
			if(strlen($newName) < 5)
				$error_msg = "New full name too short !";

			//Check new password
			if($newPassword === "")
				$newPassword = FALSE;

			//Check old password was supplied
			if($newPassword && strlen($oldPassword) < 5)
				$error_msg = "Old password wasn't correctly specified !";

			//Perform new password security check
			if($newPassword && $newPassword != $confirmNewPassword)
				$error_msg = "The new password confirmation is not the same as the new password !";

			//Check new password length
			if($newPassword && strlen($newPassword) < 5)
				$error_msg = "Please choose a stronger new password !";

			//Check old password validity
			if($newPassword && !isset($error_msg)){
				if(!$this->account->check_password($user['id'], $oldPassword))
					$error_msg = "Old password is invalid !";
			}

			//If there isn't any error, we can continue
			if(!isset($error_msg)){

				//Try to update user informations
				if(!$this->account->update_infos($user['id'], $newName, ($newPassword ? $newPassword : "0")))
					$error_msg = "An error occured while trying to update user informations !";
				else {

					//It is a success
					$success_msg = "User informations where sucessfully updated !";

					//Update signed in user informations
					$this->account->update_signed_in_infos();

				}

			}
		}

		//Prepare page return
		$page_src = "";

		//Load box content source
		$box_content_src = $this->load->view("profile/v_update_profile", array(

			//Generic informations
			"login_ticket" => $login_ticket,

			//Messages
			"error_msg" => isset($error_msg) ? $error_msg : FALSE,
			"success_msg" => isset($success_msg) ? $success_msg : FALSE,

		), true);

		//Include specific CSS files
		$css_files = array(
			path_css_assets("common/signed_in_box"),
			path_css_assets("profile/update"),
		);

		//Include home box
		$page_src .= $this->load->view("common/v_signed_in_box", array(

			//Generic informations,
			"login_ticket" => $login_ticket,

			//Box content
			"box_content" => $box_content_src,

		), TRUE);

		//Load page structure
		$this->display_page("Home", $css_files, array(), $page_src);

	}

}