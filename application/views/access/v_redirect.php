<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Redirection view file
 *
 * @author Pierre HUBERT
 */

?>

<!-- Redirection information box -->
<div class="redirect_box">
	<h4 class="title"> Please wait </h4>

	<div class="message">
		<p>Your are being redirected to <i><?php echo $app_infos['name']; ?>...</i></p>

		<p>If it does not work, please <a href="<?php echo $redirect_url; ?>">click here</a></p>
	</div>
</div>

<!-- Redirection header -->
<meta http-equiv="refresh" content="0;URL=<?php echo $redirect_url; ?>" />

<!-- Page stylesheet -->
<style type="text/css">

	.redirect_box {
		text-align: center;
		margin-top: 30px;
	}

	.redirect_box .title {

	}

	.redirect_box .message {
		font-size: 70%;
	}

</style>