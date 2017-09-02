<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Page structure view file
 *
 * @author Pierre HUBERT
 */

?><!DOCTYPE html>
<html>
	<head>
		<title><?php echo $page_title, " - ", app_name(); ?></title>

		<!-- Include CSS files -->
		<?php foreach($css_files as $file)
			echo "<link rel='stylesheet' href='",$file,"' />\n"; ?>
	</head>
	<body>

		<!-- Page source -->
		<?php echo $page_src; ?>

		<!-- Include Javascript files -->
		<?php foreach($js_files as $file)
			echo "<script src='",$file,"' type='text/javascript'></script>\n"; ?>
	</body>
</html>