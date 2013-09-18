<?php


include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");

$lessonsBaseID = mysql_fetch_array(mysql_query("SELECT lessonsBase.ID FROM lessonsBase WHERE lessonsBase.startHourFK='17' AND lessonsBase.endHourFK='18' AND lessonsBase.classFK='52'"));

print_r($lessonsBaseID["ID"]);

$sql=" SELECT lessons.teachersFK FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.ID='".$lessonsBaseID["ID"]."'";
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){

$lessons[]=end($row);

}

$sql=" SELECT missingTeachers.teacherFK FROM missingTeachers WHERE missingTeachers.startDay <= '2013-09-17' AND missingTeachers.endDay >= '2013-09-17' AND missingTeachers.startHourFK <= '17' AND missingTeachers.endHourFK >= '18'";
$result = mysql_query($sql);

while($row = mysql_fetch_array($result)){

$missing[]=end($row);

}

print_r($missing);

foreach($lessons as $l){

if(array_search($l,$missing)!==false){
	$teacher=$l;
	break;
}



}

$sql="SELECT lessons.ID FROM lessons INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK WHERE lessonsBase.ID='".$lessonsBaseID["ID"]."' AND lessons.teachersFK='".$teacher."'";
$result = mysql_fetch_array(mysql_query($sql));


print_r($result);

pageHeader("Formular","main");


pageFooter();
?>
