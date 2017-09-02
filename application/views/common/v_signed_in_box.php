<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home box view file
 *
 * @author Pierre HUBERT
 */

//Get informations about the user
$user = current_user_infos();

?><div class="container">
	<div class="signed_in_box">

		<!-- Box header -->
		<h2 class="box-heading">
			<a href="<?php echo base_url(), "?login_ticket=", $login_ticket; ?>">
				<?php echo app_name(); ?>
			</a>
			
		</h2>

		<!-- Sign in - out menu -->
		<div class="user-infos">
			Signed in as <?php echo $user['name']; ?><br />
			<a href="<?php echo base_url(), "?signout=1&login_ticket=", $login_ticket; ?>">Sign out</a>
			&bull;
			<a href="<?php echo base_url(), "profile/update?login_ticket=", $login_ticket; ?>">Update profile</a>
		</div>


		<!-- Box content -->
		<?php echo $box_content; ?>
	</div>
</div>