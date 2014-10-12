<?php
	define("BETA", false);
	
	define("RELATIVE_ROOT", "");
	define("ROOT_LOCATION", $_SERVER['DOCUMENT_ROOT'] . RELATIVE_ROOT);

	// Don't forget to change it in DB too (/backend/administration/sections/) + images
	define("SECTION_N", "EL");
	define("SECTION_E", "ET");
	define("SECTION_W", "WI");
	define("SECTION_M", "MB");

	// for stats
	$SECTION_ARRAY = array(SECTION_N, SECTION_E, SECTION_W, SECTION_M);

?>
