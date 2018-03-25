<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Authorized application list view file
 *
 * @author Pierre HUBERT
 */

?>
<br /><br />
<p>List of authorized apps: </p>

<ul>

<?php

//Process the list of application
foreach ($list as $row) {
	
	echo "<li>",$row["app_infos"]["name"],"</li>";

}


?>

</ul>