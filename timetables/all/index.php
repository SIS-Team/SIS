<?php
	/* /timetables/all/index.php
	 * Autor: Weiland Mathias
	 * Beschreibung:
	 *	Gibt Stundenplan von allen Klassen/Lehrern aus
	 */
include_once("../../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/database/selects.php");			//Stellt die select-Befehle zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/miscellaneous.php");		//Stellt Verschiedenes zur Verfügung
include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");		//Stellt Datumsfunktionen zur Verfügung

ifNotLoggedInGotoLogin();	//Kontrolle ob angemeldet
$permission = getPermission();
if($permission =='root' or $permission == 'admin') $admin=true;
else $admin = false;
if(!$admin && !$_SESSION['isTeacher']) noPermission();
pageHeader("Alle Stundenpl&auml;ne","main");
if(isset($_GET['mode']))
{	if(!$admin) $mode ='Klasse';
 	else $mode = $_GET['mode'];
	if($mode == 'Lehrer')$name= $_GET['teacher'];
	else $name = $_GET['class'];
	if($mode != 'Lehrer' && $mode != 'Klasse') unset($mode);
	
}
//Ausdruckbutton
echo "<div id=\"print\">";
if(isset($mode) && $mode == 'Lehrer') echo "<a href=\"".RELATIVE_ROOT."/pdf/timetables/?teacher=".$name."\" target=\"_blank\">";
else if(isset($mode) && $mode == 'Klasse')echo "<a href=\"".RELATIVE_ROOT."/pdf/timetables/?class=".$name."\" target=\"_blank\">";
echo "<button class =\"nonButton\">";
include(ROOT_LOCATION . "/data/images/print.svg");
echo "</button>";
echo "</a>";
echo "</div>";

$sql = "SELECT name FROM classes ORDER BY name";
$result = mysql_query($sql);
while($results = mysql_fetch_array($result)) {    
		$classes[]=$results;
}

$sql = "SELECT short AS name FROM teachers ORDER BY short";
$result = mysql_query($sql);
while($results = mysql_fetch_array($result)) {    
		$teachers[]=$results;
}
?>
<script type="text/javascript">

var show_elements = function()
{
	var elementNames = show_elements.arguments;
	for (var i=0; i<elementNames.length; i++)
   	{
     	var elementName = elementNames[i];
     	document.getElementById(elementName).style.display='block';
   	}
}

var hide_elements = function()
{
	var elementNames = hide_elements.arguments;
	for (var i=0; i<elementNames.length; i++)
   	{
     	var elementName = elementNames[i];
     	document.getElementById(elementName).style.display='none';
   	}
} 

</script>

<?php
echo "<form method=\"get\">";

echo "<select name=\"mode\" style=\"color:#000\">";
	if($admin) {
 		echo "<option style=\"color:#000\" onclick=\"show_elements('selected_teacher');hide_elements('selected_class')\" selected>Lehrer</option>";
	}
	echo "<option style=\"color:#000\" onclick=\"show_elements('selected_class');hide_elements('selected_teacher')\" ";
	if(isset($mode) and $mode == 'Klasse') echo "selected";
	 echo ">Klasse</option>";
echo "</select>";

echo "<div id=\"selected_class\"";
if(!isset($mode) or $mode != 'Klasse')echo "style= \" display : none\"";
echo ">";
	echo "<datalist id='class' style=\"color:#000\">";
		for($i=0;$i<count($classes);$i++)
		{   echo  "<option style=\"color:#000\">";
			echo $classes[$i]['name']."</option>";
		}
	echo "</datalist>";
	if(isset($_GET['class']))$temp = "value ='".$_GET['class']."'";
	else $temp = "";
	echo "<input list='class' name='class' ".$temp."></input>"; 
echo "</div>";

echo "<div id = \"selected_teacher\"";
if(isset($mode) and $mode != 'Lehrer')echo " style= \" display : none\"";
echo ">";
	echo "<datalist id='teacher' style='color:#000'>";
		for($i=0;$i<count($teachers);$i++)
		{
			if(isset($_GET['teacher']) and $teachers[$i]['name'] == $_GET['teacher'])echo "<option style=\"color:#000\" selected>";
		  	else echo  "<option style=\"color:#000\">";
			echo $teachers[$i]['name']."</option>";
		}
	echo "</datalist>";
	if(isset($_GET['teacher']))$temp = "value ='".$_GET['teacher']."'";
	else $temp = "";
	echo "<input list='teacher' name='teacher' ".$temp."></input>";// value='".."'

echo "</div>";

echo "<input type=\"submit\">";

echo "</form>";

if(isset($mode) && isset($name)){
	$lessons = getLessons ($name,$mode);
	$hours = orderLessons($lessons);

	$classType = isEvening($hours);	//kontrolliert ob Abendschule
	if($classType == "evening")	//nur Abendschule
	{
 		$tableBegin = 12;
	 	$tableEnd=17;}
	 
	else {	//nur erste 11 Stunden
 		if($classType == "normal"){
 			$tableBegin = 1;
 			 $tableEnd = 12;
 		}
 		else{ 	//alle Stunden 	
 			$tableBegin = 1;
 			$tableEnd = 17;
 		}
 	}

	echo "<div class ='timetable_column'>";
	echo "<table border = 1>";
	echo "<tr><th>Stunde</th><th>Mo</th><th>Di</th><th>Mi</th><th>Do</th><th>Fr</th></tr>";
	for($i = $tableBegin;$i<$tableEnd;$i++)
	{ 
	 	echo "<tr><td>".$i."</td>";
		for($j=1;$j<6;$j++)
		{	$title = "";
 			$weekday = dayShort($j);
			if(isset($hours[$i][dayShort($j)])){
				if($mode =='Lehrer') { $title = $hours[$i][dayShort($j)]->clName ." "; }
				if($mode =='Klasse') {$title = $hours[$i][dayShort($j)]->teShort."&#xD;";}
				$title .=$hours[$i][dayShort($j)]->roName;
				echo "<td title = \"".$title."\">".$hours[$i][dayShort($j)]->suShort."</td>";
			}
			else echo "<td>&#160;</td>";
		}
		echo "</tr>";
		 
	}
	
	echo "</table>";
	echo "</div>";
}
else{
	echo "Sie m&uuml;ssen einen g&uuml;tigen Stundenplan ausw&auml;hlen!";

}
pageFooter();

function getLessons($name,$mode){
	if($mode == 'Klasse') $where = "classes.name = '".mysql_real_escape_string($name) ."'";
	else $where = "teachers.short = '".mysql_real_escape_string($name)."'";

	$result = selectLesson($where,"");
	$lessons = array();
	while ($row = mysql_fetch_object($result)) {
		$lessons[] = $row;
	}
	return $lessons;
}

function orderLessons($lessons){
 $hours = array();
	for($i=0;$i <count($lessons);$i++)
	{ $countHour = $lessons[$i]->startHour;
 		if(!isset($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort])){
			$hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort] = $lessons[$i];	

			for($countHour++; $countHour <= $lessons[$i]->endHour; $countHour++)
			{
 				$hours[$countHour][$lessons[$i]->weekdayShort] = $lessons[$i];
 			}
		}
		else{
 			if(!strpos($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort,$lessons[$i]->suShort)){
				if($hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort != $lessons[$i]->suShort)
				{
 					$hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->suShort .= " | ". $lessons[$i]->suShort;
					
					
				}
			}
			$hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->roName  .= " | ". $lessons[$i]->roName;
			$hours[$lessons[$i]->startHour][$lessons[$i]->weekdayShort]->teShort  .= " | ". $lessons[$i]->teShort;	
		}

	
	}	
return $hours;
}

function isEvening($hours)
{
 $check = 0;
 for ($i = 1; $i < 12; $i++)	//wenn erste 11 Stunden leer -> Abendschule
 	{
 	 if (!isset($hours[$i])) $check++;
	  }
	if($check == 11) return "evening";;
	
	$check = 0;
 for ($i = 12; $i < 17; $i++) //wenn erste 11 Stunden befüllt und letzte 5 Stunden leer -> normal
 	{
 	 if (!isset($hours[$i])) $check++;
 	 }	
	if($check == 5) return "normal";
	else return "all";	//alle Stunden
}


?>