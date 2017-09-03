<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Update profile informations
 *
 * @author Pierre HUBERT
 */

//Get user informations
$user = current_user_infos();

//Check for error message
$error_msg = isset($error_msg) ? $error_msg : FALSE;

//Check for success message
$success_msg = isset($success_msg) ? $success_msg : FALSE;

?><!-- Go back home -->
<div class="go_home_link">
	<a href="<?php echo base_url(), "?login_ticket=", $login_ticket; ?>">Go back home</a>
</div>

<!-- Update form -->
<form class="update_profile_form" method="post" action="<?php echo base_url(), "profile/update?login_ticket=", $login_ticket; ?>">

	<!-- CSRF token -->
	<?php csrf_input_field(); ?>

	<!-- Error message -->
	<?php if($error_msg) echo '<div class="error-msg text-danger">',$error_msg,'</div>'; ?>

	<!-- Success message -->
	<?php if($success_msg) echo '<div class="success-msg text-success">',$success_msg,'</div>'; ?>

	<!-- Full name -->
	<label for="inputName">Full name</label>
	<input type="text" id="inputName" name="inputName" class="form-control" placeholder="Full name" value="<?php echo $user['name']; ?>" required autofocus />

	<!-- Email address -->
	<label for="inputEmail">Email address</label>
	<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $user['email']; ?>" disabled />

	<!-- Info password -->
	<h5 class="password_msg">Update password</h5>

	<!-- Password -->
	<label for="inputPassword" >Old password</label>
	<input type="password" id="inputOldPassword" name="oldPassword" class="form-control" placeholder="Old password" />

	<!-- Password -->
	<label for="inputPassword">New password</label>
	<input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New password" />

	<!-- Confirm password -->
	<label for="inputPassword">Confirm new password</label>
	<input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control" placeholder="Confirm new password" />

	<!-- Submit form -->
	<button class="btn btn-lg btn-primary btn-block" type="submit">Update profile</button>

</form>