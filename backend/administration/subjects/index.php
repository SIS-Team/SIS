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

require("../../../config.php");

require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("Fach", __FILE__);

if (!($_SESSION['rights']['root'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

if(!empty($_POST['save']) && $_POST['save']!=""){
	HashCheck($hashGenerator);
	subjects();
}
//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",		""),
	array( "name", 		"Name: ", 			"text", 	"60",	"",		"",		"required"),
	array( "short", 	"K&uuml;rzel: ", 	"text", 	"10",	"",		"",		"required"),
	array( "invisible", "Unsichtbar: ", 	"checkbox",	"",		"",		"",		""),		
	);


//Seitenheader
pageHeader("F&auml;cher","main");

$hashGenerator->generate();
HashFail();

$sort = "invisible,short";
$result = selectAll("subjects","",$sort);		//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_new($fields,$row,$hashGenerator);		//Formular wird erstellt
}

form_new($fields,false,$hashGenerator);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
