<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Successfully signed up view file
 *
 * @author Pierre HUBERT
 */

?><div class="container">

	<div class="form-signup">

		<!-- App name -->
		<h2 class="form-signup-heading"><?php echo app_name(); ?></h2>

		<!-- Message -->
		<p class="form-signup-msg">Your account was successfully created. Please login now with your new account.</p>

		
		<!-- Submit form -->
		<a class="btn btn-lg btn-primary btn-block" href="<?php echo base_url(), "login?login_ticket=", $login_ticket; ?>" >Sign in</a>

	</div>
</div>