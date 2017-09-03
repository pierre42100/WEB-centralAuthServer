<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Signup view file
 *
 * @author Pierre HUBERT
 */

//Check for error message
$error_msg = isset($error_msg) ? $error_msg : false;

?><div class="container">

	<form class="form-signup" method="post" action="<?php echo base_url(), "signup?login_ticket=", $login_ticket; ?>">

		<!-- CSRF token -->
		<?php csrf_input_field(); ?>

		<!-- App name -->
		<h2 class="form-signup-heading"><?php echo app_name(); ?></h2>

		<!-- Message -->
		<p class="form-signup-msg">New account</p>

		<!-- Error message -->
		<?php if($error_msg) echo '<div class="error-msg text-danger">',$error_msg,'</div>'; ?>

		<!-- Full name -->
		<label for="inputName">Full name</label>
		<input type="text" id="inputName" name="inputName" class="form-control" placeholder="Full name" value="<?php echo $default_name; ?>" required autofocus />

		<!-- Email address -->
		<label for="inputEmail">Email address</label>
		<input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" value="<?php echo $default_email; ?>" required  />

		<!-- Password -->
		<label for="inputPassword" >Password</label>
		<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required />

		<!-- Password -->
		<label for="inputPassword">Confirm password</label>
		<input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Password" required />


		<!-- Links -->
		<div class="bottomLinks">
			<a href="<?php echo base_url(), "login?login_ticket=", $login_ticket; ?>">I already have an account</a>
		</div>
		
		<!-- Submit form -->
		<button class="btn btn-lg btn-primary btn-block" type="submit">Create account</button>

	</form>

</div>