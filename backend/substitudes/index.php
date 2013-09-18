<script type="text/javascript">
function Visibility(id) {
if(document.getElementById('visibleRow'+id).style.visibility=="visible")
	document.getElementById('visibleRow'+id).style.visibility="collapse";
else
	document.getElementById('visibleRow'+id).style.visibility="visible";
}
function myFunction()
{
alert("I am an alert box!");
}
</script>

<?php

	/* /backend/substitude.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Supplierungen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung

if($_POST['save']!="")
	substitudes();

//Formularmaske
$fieldsRow1 = array(
	array( "ID", 		"",			 		"hidden", 		"",		"",		"",					""),
	array( "move",	 	"Verschiebung: ", 	"checkboxJava", "8",	"",		"",					""),
	array( "clName", 	"Klasse: ", 		"dropdown", 	"8",	"",		$selectClasses,		""),
	array( "suShort", 	"Fach: ", 			"dropdown", 	"8",	"",		$selectSubjects,	""),
	array( "teShort", 	"Supplierlehrer: ",	"dropdown", 	"5",	"",		$selectTeachers,	""),
	array( "time", 		"Datum: ",			"text",			"10",	"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown",		"8",	"",		$selectRooms,		""),
	array( "startHour",	"Start-Std.: ", 	"text",			"5",	"",		"",					""),
	array( "endHour",	"End-Std.: ",	 	"text",			"4",	"",		"",					""),
	array( "hidden",	"Ausblednen? ", 	"checkbox",		"",		"",		"",					""),
	array( "sure", 		"Sicher? ", 		"checkbox",		"",		"",		"true",				""),
	array( "comment", 	"Kommentar: ", 		"text",			"25",	"",		"",					""),
	);
	
$fieldsRow2 = array(
	array( "newStartHour",  "Neue Start-St.: ", 	"text",		"5",	"",		"",		""),
	array( "newEndHour",	"Neue End-St.: ",		"text",		"4",	"",		"",		""),
	);


//Seitenheader
pageHeader("Formular","main");

$result = selectSubstitude("","");			//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	form_substitudes($fieldsRow1,$fieldsRow2 ,$row);		//Formular wird erstellt
}

form_substitudes($fieldsRow1,$fieldsRow2,false);			//Formular für einen neuen Eintrag

//Seitenfooter
pageFooter();
?>
