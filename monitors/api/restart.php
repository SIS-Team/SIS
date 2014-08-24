<?php
	require("../../config.php");
	
	if (file_exists(ROOT_LOCATION . "/tmp/restartx.ex")) {
		echo "kill";
	} else {
		echo "false";
	}
?>
