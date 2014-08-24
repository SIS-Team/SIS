<?php
	require("../../config.php");
	require(ROOT_LOCATION . "/modules/monitors/Main.php");

	$monitor = getMonitorByName($_GET['name']);

	if (!$monitor)
		die("none");

	if ($monitor->displayMode == "permanent Ein")
		die("true");
	else if ($monitor->displayMode == "permanent Aus")
		die("false");
	else {
	
		// monitor off on sat and sun
		if (date("N") >= 6)
			die("true");
	
		$on = $monitor->startTime;
		$off = $monitor->endTime;
		$on = $on % (24 * 60 * 60);
		$off = $off % (24 * 60 * 60);
		
		$now = time();
		
		$now += date("I") * 60 * 60;
		
		$now = $now % (24 * 60 * 60);

		if ($now > $on && $now < $off)
			die ("true");
		else
			die ("false");
	}	

?>
