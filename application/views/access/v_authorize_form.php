<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authorize form - view file
 *
 * @author Pierre HUBERT
 */

?>
<!-- Form -->
<form class="authorize_form" action="<?php echo base_url(), "access/authorize?login_ticket=", $login_ticket; ?>" method="post">

	<!-- Message -->
	<div class="msg">
		Do you authorize <b><?php echo $app_infos['name']; ?></b>
		(<i><?php echo $app_infos['description']; ?></i>) to access
		your account informations (e-mail, full name, id) ?
	</div>

	<!-- Buttons -->
	<div class="buttons">

		<!-- Deny -->
		<button class="btn btn-secondary" type="submit" value="false" name="authorize">Deny</button>

		<!-- Allow -->
		<button class="btn btn-primary" type="submit" value="true " name="authorize">Allow</button>

	</div>

</form>

<!-- Specific stylesheet -->
<link rel="stylesheet" href="<?php echo path_css_assets('access/authorize_form'); ?>" />