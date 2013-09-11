
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

include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung




//Seitenheader
pageHeader("Formular","main");

printf("<form method=\"post\" action=\"lessons.php\"> ");
printf("Klasse wählen: <input autocomplete=\"off\" list=\"class\" name=\"class\" size=\"5\"><datalist id=\"class\">\n");
					
foreach($selectClasses as $p)							//FÃ¯Â¿Â½r jeden MenÃ¯Â¿Â½eintrag im Array f einen Eintrag erstellen
{
	printf("<option value=\"%s\">\n", $p[0]);
}

printf("</datalist>\n");

printf("Tag wählen: <input autocomplete=\"off\" list=\"day\" name=\"day\" size=\"3\" value=\"Mo\"><datalist id=\"day\">\n");
							
foreach($selectDays as $p)							//FÃ¯Â¿Â½r jeden MenÃ¯Â¿Â½eintrag im Array f einen Eintrag erstellen
{
	printf("<option value=\"%s\">\n", $p[0]);
}

printf("</datalist>\n");


printf("<input type=\"submit\" name=\"ok\" value=\"Speichern\">\n");	//Submit Button erstellen
printf("</form>");

pageFooter();
?>
