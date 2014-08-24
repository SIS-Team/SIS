<?php
	require("../../config.php");
	require(ROOT_LOCATION . "/modules/monitors/Main.php");

	$monitor = getMonitorByName($_GET['name']);

	if (!$monitor) {
		echo "none";
		exit();
	}

	if ($monitor->displayMode == "permanent Ein") {
		echo "true";
		exit();
	} else if ($monitor->displayMode == "permanent Aus") {
		echo "false";
		exit();
	} else {
		// monitor off on sat and sun
		if (date("N") >= 6) {
			echo "true";
			exit();
		}
	
		$on = $monitor->startTime;
		$off = $monitor->endTime;
		$on = $on % (24 * 60 * 60);
		$off = $off % (24 * 60 * 60);
		
		$now = time();
		
		$now += date("I") * 60 * 60;
		
		$now = $now % (24 * 60 * 60);

		if ($now > $on && $now < $off) {
			echo "true";
			exit();
		} else {
			echo "false";
			exit();
		}
	}	

?>
