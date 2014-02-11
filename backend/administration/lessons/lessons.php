<?php
	@ob_start();

	/* /backend/lessons.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Unterrichtsstunden
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 */




include("../../../config.php");
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die Dropdownmenüs zur Verfügung
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verf�gung

if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']))
	exit();


if(empty($_POST['class'])){
	header('Location: ./');
	exit();
}
else if(empty($_POST['day']))
	$_POST['day']="Mo";

	
if(!empty($_POST['save']) && $_POST['save']!="")
	lessons();


//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown", "8",	"",		$selectRooms,		""),
	array( "teShort", 	"Lehrer: ",	 		"dropdown",	"5",	"",		$selectTeachers,	""),
	array( "suShort", 	"Fach: ", 			"dropdown",	"10",	"",		$selectSubjects,	""),
	array( "comment", 	"Kommentar: ",		"text",		"20",	"",		"",					""),
	);

include(ROOT_LOCATION . "/modules/general/Menu.php");
generateAdminMenu();


//Seitenheader
pageHeader("Formular","main");

printf("<script language=\"javascript\" type=\"text/javascript\" src=\"%s/data/scripts/lessons.js\"></script>",RELATIVE_ROOT);



printf("Klasse: <a href=\"index.php\" >%s</a> und der Tag: %s",$_POST['class'],$_POST['day']);
$days=prevNextDay($_POST['day']);

printf("<form action=\"lessons.php\" method=\"post\">\n");
printf("<table width=\"100%%\"><tr>");

if($days['prev']!="")
	printf("<td><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['prev']);
	
printf("<td><input type=\"hidden\" name=\"class\" value=\"%s\"</td>\n",$_POST['class']);

if($days['next']!="")
	printf("<td style=\"text-align:right\"><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['next']);
printf("</tr></table></form>\n");

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM classes WHERE name = '".$_POST["class"]."'"));
$ok1 = control($_POST['class'],$temp["ID"],"Klasse");
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM hours WHERE weekdayShort = '".$_POST["day"]."'"));
$ok2 = control($_POST['day'],$temp["ID"],"Tag");

if(($ok1*$ok2!=1))
	header("Location: ./?fail=fail");

$where="classes.name='".$_POST['class']."' AND hoursStart.weekdayShort='".$_POST['day']."'";
$sort="hoursStart.hour ASC";
$result = selectLesson($where,"");	//Rückgabewert des Selects
$content = "";
while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht

  	$sql= "SELECT COUNT(*) FROM lessons LEFT JOIN rooms ON rooms.ID = lessons.roomFK INNER JOIN teachers ON teachers.ID = lessons.teachersFK INNER JOIN subjects ON subjects.ID = lessons.subjectFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK INNER JOIN classes ON classes.ID = lessonsBase.classFK INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";	//Stamm sql-Befehl
	$where2 = " AND " . "hoursStart.hour='".$row['startHour']."' AND hoursEnd.hour='".$row['endHour']."'";
	$sql .= " WHERE " . $where.$where2; 
	
	$same = mysql_result(mysql_query($sql),0);
	//print_r($same);
	$row['same']=$same;
	$content[] = $row;
}

//print_r(end($content));
//print_r($content);
form_lesson($fields,$content);		//Formular wird erstellt



if(!empty($_POST['hour'])){

	
	printf("<script type=\"text/javascript\">text(%s,%s); Visibility(%s);</script>",$_POST['visibilityText'.$_POST['hour']],$_POST['hour'],$_POST['hour']);
}
//Seitenfooter
pageFooter();
?>
