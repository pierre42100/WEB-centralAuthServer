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
		<!-- Title of the page -->
		<title><?php echo $page_title, " - ", app_name(); ?></title>

		<!-- UTF-8 support -->
        <meta charset="utf-8">

        <!-- Shorcut icon -->
        <link rel="shortcut icon" href="<?php echo path_img_assets('key.png'); ?>"/>

        <!-- Responsive website -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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