<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main login view file
 *
 * @author Pierre HUBERT
 */

?><div class="container">

	<form class="form-signin" method="post" action="<?php echo base_url(), "login?login_ticket=", $login_ticket; ?>">

		<!-- App name -->
		<h2 class="form-signin-heading"><?php echo app_name(); ?></h2>

		<!-- Message -->
		<!--<p class="form-signin-msg">Please sign in into the system</p>-->

		<!-- Email address -->
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus />

		<!-- Password -->
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" required />


		<!-- Links -->
		<div class="bottomLinks">
			<a href="<?php echo base_url(), "signup?login_ticket=", $login_ticket; ?>">Create an account</a>
		</div>
		
		<!-- Submit form -->
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

	</form>

</div>