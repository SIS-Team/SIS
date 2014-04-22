<?php
	/* /modules/general/Site.php
	 * Autor: Buchberger Florian
	 * Beschreibung:
	 *	Stellt Funktionen für den Seitenaufbau zur Verfügung
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
	$seperators['js'] = "&js;";

	/*
	 * Läd die Design Datei und splittet sie nach dem seperator "main" auf.
	 * Parameter: $filename - Dateiname als String
	 */
	function getDesignFile($filename) {
		global $siteContents, $seperators, $_GET;
		$handle = fopen($filename, "r");
		$content = "";
		
		while (true) {
			$tmp = fgets($handle);
			if ($tmp == null) break;
			$content .= $tmp;
		}
	
		$content = str_replace($seperators['root'], RELATIVE_ROOT, $content);
		if (isset($_GET['js']))
			$js = "true";
		else
			$js = "false";
			
		$content = str_replace($seperators['js'], $js, $content);
			
			
		$tmp = strpos($content, $seperators["main"]);
		$siteContents["header"] = substr($content, 0, $tmp);
		$siteContents["footer"] = substr($content, $tmp + strlen($seperators["main"]));
	}

	/*
	 * Läd Design und gibt den Teil bis zum "main"-seperator aus.
	 * Parameter: $title - Titel der Seite als String
	 * 	      $design - Designname als String
	 */
	function pageHeader($title, $design, $mobile = true) {
		global $siteContents, $seperators;

		header('Content-Type: text/html; charset=UTF-8');
		header('X-Frame-Options: SAMEORIGIN');

		getDesignFile(ROOT_LOCATION . "/modules/design/" . $design . ".html");
		$site = str_replace($seperators["title"], $title, $siteContents["header"]);
		$site = str_replace($seperators["sidebar"], $siteContents["sidebar"], $site);
		
		if ($mobile)
			$mobile = "true";
		else
			$mobile = "false";
		$site = str_replace($seperators['mobile'], $mobile, $site);
		
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
