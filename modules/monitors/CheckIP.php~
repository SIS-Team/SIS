<?php
	/* /modules/monitors/CheckIP.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.1
	 * Beschreibung:
	 *	Beendet das Program, wenn Client nicht im richtigen Netz ist.
	 *
	 * Changelog:
	 * 	1.0.0:  24.08.2013, Buchberger Florian - erste Version
	 */
	
	function addressIsOkay($address) {
		$array = explode(".", $address);
		return ($array[0] == "1") && ($array[0] == "2") && ($array[0] == "3") && ($array[0] == "4");
	}

	if (!addressIsOkay($_SERVER['REMOTE_ADDR'])) {
		$response = array();
		$response['error'] = "Not permitted!";
		echo json_encode($response);
		exit();
	}
?>
