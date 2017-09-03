<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main login view file
 *
 * @author Pierre HUBERT
 */

//Check for error message
$error_msg = isset($error_msg) ? $error_msg : false;

?><div class="container">

	<form class="form-signin" method="post" action="<?php echo base_url(), "login?login_ticket=", $login_ticket; ?>">

		<!-- CSRF token -->
		<?php csrf_input_field(); ?>

		<!-- App name -->
		<h2 class="form-signin-heading"><?php echo app_name(); ?></h2>

		<!-- Message -->
		<!--<p class="form-signin-msg">Please sign in into the system</p>-->

		<!-- Error message -->
		<?php if($error_msg) echo '<div class="error-msg text-danger">',$error_msg,'</div>'; ?>

		<!-- Email address -->
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" name="inputEmail" class="form-control" value="<?php echo $default_mail; ?>" placeholder="Email address" required autofocus />

		<!-- Password -->
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required />


		<!-- Links -->
		<div class="bottomLinks">
			<a href="<?php echo base_url(), "signup?login_ticket=", $login_ticket; ?>">Create an account</a>
		</div>
		
		<!-- Submit form -->
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

	</form>

</div>