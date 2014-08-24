<?php

	/* /backend/substitude/index.php
	 * Autor: Handle Marco
	 * Beschreibung:
	 * Erstellt die Formulare fuer die Eingabe der Supplierungen
	 *
	 */

require("../../../config.php");
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/dateChange.php");			//Stell die Funktion für die Datumsauswahl zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");					
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("Substitudes", __FILE__);

if(empty($_GET['section']) && empty($_POST['section'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}
else if($_GET['section']!="")
	$section = $_GET['section'];


if (!($_SESSION['rights']['root'] || $_SESSION['rights'][$section])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}
$fail="";
if(!empty($_POST['save']) && $_POST['save']!=""){
	HashCheck($hashGenerator);
	$fail = substitudes();
}

if (empty($_POST["date"]) && empty($_POST['time'])) {		//wenn nichts zurückgegeben wird, dann heute
	$date = no_weekend(strftime("%Y-%m-%d"));
}
else if(!empty($_POST["date"]) && $_POST['date']!=""){								//sonst zurückgegebenes Datum
	$date = no_weekend($_POST["date"]);
}
else{
	$date = no_weekend($_POST['time']);
}

//Seitenheader
pageHeader("Supplierungen eintragen","main");

$hashGenerator->generate();

HashFail();

$dropDown=array("ClassesSub","Subjects","Teachers","Rooms");
require_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung


//Formularmaske
$fieldsRow1 = array(
	array( "ID", 		"",	 		"hidden", 		"",	"",	"",			""),
	array( "time",		"Datum:",		"hidden",		"10",	"",	"",			"readonly=\"true\",required"),	
	array( "free",	 	"Freie Eingabe: ", 	"checkboxJava", 	"8",	"",	"",			""),
	array( "clName", 	"Klasse: ", 		"dropdown", 		"8",	"",	$selectClasses,		""),
	array( "suShort", 	"Fach: ", 		"dropdown", 		"8",	"",	$selectSubjects,	""),
	array( "teShort", 	"Supplierlehrer: ",	"dropdown", 		"5",	"",	$selectTeachers,	""),
	array( "roName",	"Raum: ", 		"dropdown",		"8",	"",	$selectRooms,		""),
	array( "startHour",	"Start-Std.: ", 	"text",			"5",	"",	"",			""),
	array( "endHour",	"End-Std.: ",	 	"text",			"4",	"",	"",			""),
	array( "comment", 	"Kommentar: ", 		"text",			"25",	"",	"",			""),
	);
	
$fieldsRow2 = array(
	array( "move",	 	"Verschiebung: ", 	"radio", 		"8",	"",	"",			""),
	array( "add",	 	"Hinzuf&uuml;gen: ", 	"radio", 		"8",	"",	"",			""),
	array( "remove",	"Entf&auml;llt: ", 	"radio", 		"8",	"",	"",			""),
	array( "oldStartHour",  "Urs. Start-St.: ", 	"text",		"5",	"",		"",		""),
	array( "oldEndHour",	"Urs. End-St.: ",	"text",		"4",	"",		"",		""),
	array( "oldTeShort",  	"Urs. Lehrer: ", 	"dropdown",	"5",	"",		$selectTeachers,""),
	);
if($fail===false)
	printf("<div>Es ist ein Fehler bei der Eingabe aufgetreten. M&ouml;glicherweise ist f&uuml;r diese Stunde keine Supplierung<br>n&ouml;tig, weil der Lehrer nicht verhindert ist oder ein anderer Eingabefehler ist aufgetreten<div><br><br>");


printf("<script language=\"javascript\" type=\"text/javascript\" src=\"%s/data/scripts/substitudes.js\"></script>",RELATIVE_ROOT);
printf("<noscript><br>Bitte aktivieren Sie JavaScript. Ohne JavaScript kann keine korrekte Eingabe der Supplierungen erfolgen.<br><br></noscript>");

$date = dateChange($date);		//Datumsauswahl erzeugen
$fieldsRow1[1][5] = $date;	//Standartdatum ins Formular schreiben

$where = "substitudes.time = '".$date."' AND sections.short = '".$section."'";		//Filter
$sort = "classes.name, hoursStart.hour";		//Sortierung nach dem Klassenname und der Startstunde

?>
<br />
<br />
<div id="print">
	<a href="<?php echo RELATIVE_ROOT; ?>/pdf/substitudes/?date=<?php echo $date; ?>&section=<?php echo $section; ?>" target="_blank">
		<button class="nonButton">
			<?php require(ROOT_LOCATION . "/data/images/print.svg"); ?>
		</button>
	</a>
</div>
<?php

$result = selectSubstitude($where,$sort);			//Rückgabewert des Selects

while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
	//print_r($row);
	form_substitudes($fieldsRow1,$fieldsRow2 ,$row,$section,$hashGenerator);		//Formular wird erstellt
}
if($fail===false)
	form_substitudes($fieldsRow1,$fieldsRow2,$_POST,$section,$hashGenerator);			//Formular für einen neuen Eintrag
else
	form_substitudes($fieldsRow1,$fieldsRow2,false,$section,$hashGenerator);			//Formular für einen neuen Eintrag
//Seitenfooter
pageFooter();
?>
