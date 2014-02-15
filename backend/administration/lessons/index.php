
<?php

	/* /backend/lessons/index.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 * Auswahl der Klasse
	 *
	 * Changelog:
	 * 	0.1.0:  06. 09. 2013, Handle Marco - erste Version
	 */

include("../../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");

if (!($_SESSION['rights']['root']))
	header("Location: ".RELATIVE_ROOT."/");


$fail = "";
if(!empty($_GET['fail']) && isset($_GET['fail']))
	$fail = "Klasse oder Tag falsch eingegeben.<br>";
//Seitenheader
pageHeader("Stundenpl&auml;ne","main");

$dropDown=array("Classes","Days");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung

$hashGenerator = new HashGenerator("Auswahl-Stundenplan", __FILE__);
$hashGenerator->generate();


printf("<form method=\"post\" action=\"lessons.php\"> ");
$hashGenerator->printForm();
printf("%s",$fail);
printf("Klasse w&auml;hlen: <input autocomplete=\"off\" list=\"clName\" name=\"class\" size=\"8\" required>");
printf("Tag w&auml;hlen: <input autocomplete=\"off\" list=\"day\" name=\"day\" size=\"3\" value=\"Mo\" required>\n");
							

printf("<input type=\"submit\" name=\"ok\" value=\"Speichern\">\n");	//Submit Button erstellen
printf("</form>");

pageFooter();
?>
