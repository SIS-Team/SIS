
<?php

	/* /backend/index.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 * Auswahl der Klasse
	 *
	 * Changelog:
	 * 	0.1.0:  06. 09. 2013, Handle Marco - erste Version
	 */
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung


include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Menu.php");
generateAdminMenu();


if(isset($_GET['fail']))
	$fail = "Klasse oder Tag falsch eingegeben.<br>";
//Seitenheader
pageHeader("Formular","main");

printf("<form method=\"post\" action=\"lessons.php\"> ");
printf("%s",$fail);
printf("Klasse wählen: <input autocomplete=\"off\" list=\"clName\" name=\"class\" size=\"8\">");
printf("Tag wählen: <input autocomplete=\"off\" list=\"day\" name=\"day\" size=\"3\" value=\"Mo\">\n");
							

printf("<input type=\"submit\" name=\"ok\" value=\"Speichern\">\n");	//Submit Button erstellen
printf("</form>");

pageFooter();
?>
