<?php

	/* /backend/lessons.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Unterrichtsstunden
	 *
	 */



require_once("../../../config.php");
require_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur VerfÃ¼gung
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur VerfÃ¼gung
require_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur VerfÃ¼gung
require_once(ROOT_LOCATION . "/modules/database/inserts.php");			//Stellt die insert-Befehle zur Verfügung
require_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");			
require_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		

$hashGenerator = new HashGenerator("Stundenplan", __FILE__);


if (!($_SESSION['rights']['root'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

if(empty($_GET['class']) && empty($_POST['class'])){
	header('Location: ./');
	exit();
}
else if(empty($_POST['class']))
{
	$_POST['class']=$_GET['class'];
}

if(empty($_GET['day']) && empty($_POST['class']))
	$_POST['day']="Mo";
else if(empty($_POST['day']))
	$_POST['day']=$_GET['day'];

	
if(!empty($_POST['save']) && $_POST['save']!=""){
	HashCheck($hashGenerator);
	lessons();
}
if(!empty($_POST['hourDelete']) && $_POST['hourDelete']!=""){
	hourDelete();
}


//Seitenheader
pageHeader("Stundenpl&auml;ne","main");

$hashGenerator->generate();
HashFail();

$dropDown=array("Subjects","Teachers","Rooms");
require_once(ROOT_LOCATION . "/modules/form/dropdownSelects.php");		//Stellt die Listen für die DropdownmenÃ¼s zur VerfÃ¼gung

//Formularmaske
$fields = array(
	array( "ID", 		"",			 		"hidden", 	"",		"",		"",					""),
	array( "roName",	"Raum: ", 			"dropdown", "8",	"",		$selectRooms,		""),
	array( "teShort", 	"Lehrer: ",	 		"dropdown",	"5",	"",		$selectTeachers,	"required"),
	array( "suShort", 	"Fach: ", 			"dropdown",	"10",	"",		$selectSubjects,	"required"),
	array( "comment", 	"Kommentar: ",		"text",		"20",	"",		"",					""),
	);


printf("<script language=\"javascript\" type=\"text/javascript\" src=\"%s/data/scripts/lessons.js\"></script>",RELATIVE_ROOT);
printf("<noscript><br>Bitte aktivieren Sie JavaScript. Ohne JavaScript kann keine korrekte Eingabe der Stundenpl&auml;ne erfolgen<br><br></noscript>");


printf("Klasse: <a href=\"index.php\" >%s</a> und der Tag: %s",$_POST['class'],$_POST['day']);
$days=prevNextDay($_POST['day']);
//HashCheck();
printf("<form method=\"POST\"><button type=\"submit\" name=\"hourDelete\" value=\"hourDelete\">Stundenplan l&ouml;schen</button>");
printf("<input type=\"hidden\" name=\"class\" value=\"%s\">",$_POST['class']);
printf("<input type=\"hidden\" name=\"day\" value=\"%s\">",$_POST['day']);
printf("</form>");
printf("<form action=\"lessons.php\" method=\"POST\">\n");
printf("<table width=\"100%%\"><tr>");

if($days['prev']!="")
	printf("<td><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['prev']);
	
printf("<td><input type=\"hidden\" name=\"class\" value=\"%s\"</td>\n",$_POST['class']);

if($days['next']!="")
	printf("<td style=\"text-align:right\"><input type=\"submit\" value=\"%s\" name=\"day\"></td>\n",$days['next']);
printf("</tr></table></form>\n");

$where="classes.name='".$_POST['class']."' AND hoursStart.weekdayShort='".$_POST['day']."'";
$sort="hoursStart.hour ASC";
$result = selectLesson($where,"");	//Rückgabewert des Selects
$content = "";
while ($row = mysql_fetch_array($result)){	//Fügt solange eine neue Formularzeile hinzu, solange ein Inhalt zur Verfügung steht
  	$sql= "SELECT COUNT(*) FROM lessons 
  			LEFT JOIN rooms ON rooms.ID = lessons.roomFK 
  			INNER JOIN teachers ON teachers.ID = lessons.teachersFK 
  			INNER JOIN subjects ON subjects.ID = lessons.subjectFK 
  			INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK 
  			INNER JOIN classes ON classes.ID = lessonsBase.classFK 
  			INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK 
  			INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";	//Stamm sql-Befehl
	$where2 = " AND " . "hoursStart.hour='".$row['startHour']."' AND hoursEnd.hour='".$row['endHour']."'";
	$sql .= " WHERE " . $where.$where2; 
	
	$same = mysql_result(mysql_query($sql),0);
	$row['same']=$same;
	$content[] = $row;
}

form_lesson($fields,$content,$hashGenerator);		//Formular wird erstellt

if(!empty($_POST['hour'])){
	printf("<script type=\"text/javascript\">text(%s,%s); Visibility(%s);</script>",$_POST['visibilityText'.$_POST['hour']],$_POST['hour'],$_POST['hour']);
}
//Seitenfooter
pageFooter();
?>
