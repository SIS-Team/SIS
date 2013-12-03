<?php
	function generateDefaultMenu () {
		global $siteContents;
		$bar = '<ul><li><a href="/">Startseite</a></li>';
		if ($_SESSION['loggedIn']) {
			$bar .= '<li><a href="/timetables/classes/">Stundenplan</a></li>';
			$bar .= '<li><a href="/substitudes/">Supplierplan</a></li>';
			$bar .= '<li><a href="/logout/">Logout</a></li>';
		} else {
			$bar .= '<li><a href="/login/">Login</a></li>';
		}
		$bar .= "</ul>";

		if ($_SESSION['loggedIn'] && ($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'] || $_SESSION['rights']['news']))
			$bar .= '<ul><li><a href="/backend/">Admin-Bereich</li></ul>';


		$bar .= '<ul><li><a href="/problems/">Probleme?</a></li><li><a href="/impressum/">Impressum</a></li></ul>';

		$siteContents['sidebar'] = $bar;
	}
	
	function generateAdminMenu () {
		global $siteContents;
		$bar = '<ul><li><a href="/backend/">Startseite</a></li></ul>';
		
		$bar .= '<ul>';
	
		if ($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']) {
			$bar .= '<li><a href="/backend/missingTeacher">fehlende Lehrer</a></li>';
                        $bar .= '<li><a href="/backend/missingClasses">fehlende Klassen</a></li>';
		}

		if ($_SESSION['rights']['root'] || $_SESSION['rights']['N']) {
			$bar .= '<li><a href="/backend/substitudes/?section=N">Supplierungen (N)</a></li>';
		}
		if ($_SESSION['rights']['root'] || $_SESSION['rights']['W']) {
			$bar .= '<li><a href="/backend/substitudes/?section=W">Supplierungen (W)</a></li>';
		}
		if ($_SESSION['rights']['root'] || $_SESSION['rights']['M']) {
			$bar .= '<li><a href="/backend/substitudes/?section=M">Supplierungen (M)</a></li>';
		}
		if ($_SESSION['rights']['root'] || $_SESSION['rights']['E']) {
			$bar .= '<li><a href="/backend/substitudes/?section=E">Supplierungen (E)</a></li>';
		}

		$bar .= "</ul>";

		
		if ($_SESSION['rights']['root']) {
			$bar .= '<ul>';
			$bar .= '<li><a href="/backend/sections/">Abteilungen</a></li>';
			$bar .= '<li><a href="/backend/rooms/">Räume</a></li>';
			$bar .= '<li><a href="/backend/teachers/">Lehrer</a></li>';
			$bar .= '<li><a href="/backend/classes/">Klassen</a></li>';
			$bar .= '<li><a href="/backend/subjects/">Fächer</a></li>';
			$bar .= '</ul>';
		}

		if ($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'] || $_SESSION['rights']['news'])
			$bar .= '<ul><li><a href="/backend/news/">News</a></li></ul>';

		if ($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M'])
			$bar .= '<ul><li><a href="/backend/monitors/">Monitore</a></li></ul>';
	
		$bar .= '<ul><li><a href="/">Benutzerbereich</a></li>';
		if ($_SESSION['loggedIn'])
			$bar .= '<li><a href="/logout/">Logout</a></li>';
		else
			$bar .= '<li><a href="/login/">Login</a></li>';
	
		$bar .= "</ul>";

		$siteContents['sidebar'] = $bar;	
	}
?>
