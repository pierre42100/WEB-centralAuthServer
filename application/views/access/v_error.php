<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Error view file
 *
 * @author Pierre HUBERT
 */

?>

<div class="error_box">

	<h3 class="error_heading">
		An error occured
	</h3>

	<div class="error_msg"><?php echo $error_msg; ?></div>

</div>

<!-- Page stylesheet -->
<style type="text/css">
	.error_box {
		border: 1px #dc3545 solid;
		padding: 10px;
		margin: 20px;
		margin-top: 30px;
		color: #dc3545;
	}

	.error_box .error_heading {
		text-align: center;
		margin-bottom: 20px;
	}

	.error_box .error_msg {
		font-style: italic;
		text-align: center;
	}
</style>