<?php

	/* /backend/subjects/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Faecher
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include("../../config.php");

include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verf�gung
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen f�r die Dropdownmen�s zur Verf�gung
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verf�gung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung

if($_POST['save']!="")
	subjects();

//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",		""),
	array( "name", 		"Name: ", 			"text", 	"60",	"",		"",		""),
	array( "short", 	"K&uuml;rzel: ", 	"text", 	"10",	"",		"",		""),
	array( "invisible", "Unsichtbar: ", 	"checkbox",	"",		"",		"",		""),		
	);

include(ROOT_LOCATION . "/modules/general/Menu.php");
generateAdminMenu();


//Seitenheader
pageHeader("Formular","main");

$sort = "invisible,short";
$result = selectAll("subjects","",$sort);		//R�ckgabewert des Selects

while ($row = mysql_fetch_array($result)){	//F�gt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verf�gung steht
	form_new($fields,$row);		//Formular wird erstellt
}

form_new($fields,false);			//Formular f�r einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
