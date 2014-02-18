
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
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("Stundenplan", __FILE__);

if (!($_SESSION['rights']['root'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}
if(!empty($_POST['ok']) && $_POST['ok']!=""){
	HashCheck($hashGenerator);
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name = '".mysql_real_escape_string(htmlspecialchars($_POST["class"]))."'"));
	$ok1 = control($_POST['class'],$temp["ID"],"Klasse");
	$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort = '".mysql_real_escape_string(htmlspecialchars($_POST["day"]))."'"));
	$ok2 = control($_POST['day'],$temp["ID"],"Tag");
	
	if(($ok1*$ok2==1)){
		header("Location: lessons.php?class=".$_POST['class']."&day=".$_POST['day']);
		exit();
	}
}

//Seitenheader
pageHeader("Stundenpl&auml;ne","main");

$hashGenerator->generate();
HashFail();

$dropDown=array("Classes","Days");
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung

printf("<noscript><br>Bitte aktivieren Sie JavaScript. Ohne JavaScript kann keine korrekte Eingabe der Stundenpl&auml;ne erfolgen<br><br></noscript>");

printf("<form method=\"post\"> ");
$hashGenerator->printForm();
printf("Klasse w&auml;hlen: <input autocomplete=\"off\" list=\"clName\" name=\"class\" size=\"8\" required>");
printf("Tag w&auml;hlen: <input autocomplete=\"off\" list=\"day\" name=\"day\" size=\"3\" value=\"Mo\" required>\n");
							

printf("<input type=\"submit\" name=\"ok\" value=\"Speichern\">\n");	//Submit Button erstellen
printf("</form>");

pageFooter();
?>
