<?php
	/* /modules/general/Site.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Stellt Funktionen für den Seitenaufbau zur Verfügung
	 *
	 * Changelog:
	 * 	0.1.0:  22. 06. 2013, Buchberger Florian - erste Version
	 *	0.2.0	24. 06. 2013, Handle MArco - Fehlerkorrektur nun lauffähig
	 */

	$siteContents = array();
	$siteContents["header"] = "";
	$siteContents["footer"] = "";
	$siteContents["sidebar"] = "";

	$seperators = array();
	$seperators["main"] = "&main;";
	$seperators["title"] = "&title;";
	$seperators["sidebar"] = "&sidebar;";
	$seperators["root"] = "&root;";
	$seperators["mobile"] = "&mobile;";

	/*
	 * Läd die Design Datei und splittet sie nach dem seperator "main" auf.
	 * Parameter: $filename - Dateiname als String
	 */
	function getDesignFile($filename) {
		global $siteContents, $seperators;
		$handle = fopen($filename, "r");
		$content = "";
		
		while (true) {
			$tmp = fgets($handle);
			if ($tmp == null) break;
			$content .= $tmp;
		}
	
		$content = str_replace($seperators['root'], RELATIVE_ROOT, $content);

		$tmp = strpos($content, $seperators["main"]);
		$siteContents["header"] = substr($content, 0, $tmp);
		$siteContents["footer"] = substr($content, $tmp + strlen($seperators["main"]));
	}

	/*
	 * LÃ¤d Design und gibt den Teil bis zum "main"-seperator aus.
	 * Parameter: $title - Titel der Seite als String
	 * 	      $design - Designname als String
	 */
	function pageHeader($title, $design, $mobile) {
		global $siteContents, $seperators;

		header('Content-Type: text/html; charset=UTF-8');

		getDesignFile(ROOT_LOCATION . "/modules/design/" . $design . ".html");
		$site = str_replace($seperators["title"], $title, $siteContents["header"]);
		$site = str_replace($seperators["sidebar"], $siteContents["sidebar"], $site);
		
		if (!isset($mobile))
			$mobile = true;
		$content = str_replace($seperators['mobile'], $mobile, $content);
		
		echo $site;
	}

	
	/*
	 * Gibt den zuvor geladenen Teil des Designs ab dem "main" seperator aus.
	 */
	function pageFooter() {
		global $seperators, $siteContents;
		$site = str_replace($seperators["sidebar"], $siteContents['sidebar'], $siteContents["footer"]);
		echo $site;
	}
?>
