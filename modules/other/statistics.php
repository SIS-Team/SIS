<?php

/* /modules/other/statistics.php
* Autor: Handle Marco,
*/


include_once(ROOT_LOCATION."/modules/other/getBrowser.php");
include_once(ROOT_LOCATION."/modules/general/Connect.php");

function get(){

$timeRelease = strtotime("02-03-2013 20:39");

//echo date("d-m-Y H:i:s",$timeRelease);

$sql = "SELECT logsSessions.userAgent FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."' AND logsMain.site NOT LIKE '%mobile/api%'";
$result = mysql_query($sql);
$row=array();
while($row=mysql_fetch_array($result)){

	$temp=getBrowser($row[0]);
	$osPC[] = $temp["os"];
	$browserPC[] = $temp["name"];
}


$sql = "SELECT logsSessions.userAgent FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."' AND logsMain.site LIKE '%mobile/api%'";
$result = mysql_query($sql);
$row=array();
while($row=mysql_fetch_array($result)){

	$temp=getBrowser($row[0]);
	$osM[] = $temp["os"];
	$browserM[] = $temp["name"];
}


for($i=1;$i<8;$i++){

$sql = "SELECT COUNT(classes.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK LEFT JOIN classes ON classes.ID = logsUsers.classesFK WHERE classes.name LIKE '".$i."%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsUsers.isTeacher='0' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$classes[]=array($i.". Jahrgang",$temp[0]);
}

$sql = "SELECT COUNT(logsUsers.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsUsers.isTeacher='1' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$classes[]=array("Lehrer",$temp[0]);
$section = array('N','E','W','M');
foreach($section as $s){

$sql = "SELECT COUNT(sections.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK LEFT JOIN sections ON sections.ID = logsUsers.sectionsFK WHERE sections.short LIKE '".$s."' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sections[]=array($s." Abteilung",$temp[0]);
}

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%timetables%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Stundenplan/Modifiziert",$temp[0]);
$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%substitudes%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Supplierplan",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%mobile/api/substitudes%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Supplierplan Mobil",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%mobile/api/alttimetables%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Modifiziert Mobil",$temp[0]);


$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%api%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$mobileWeb[]=array("App",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site NOT LIKE '%api%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$mobileWeb[]=array("Web",$temp[0]);

$browser_countM = countDat($browserM,"SORT_STRING");
$os_countM = countDat($osM,"SORT_STRING");

$browser_countPC = countDat($browserPC,"SORT_STRING");
$os_countPC = countDat($osPC,"SORT_STRING");


$row=array();
$sql = "select logsMain.site,count(*) from logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE (logsMain.site LIKE '/help%' OR logsMain.site LIKE '/news%' OR site LIKE '/substitudes/' OR logsMain.site LIKE '/timetables%' OR logsMain.site LIKE '/impressum%' ) AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."' group by logsMain.site";
$result = mysql_query($sql);
while($row[]=mysql_fetch_array($result)){
}
unset($row[count($row)-1]);
$sitesClient = $row;

$row=array();
$sql = "select logsMain.site,count(*) from logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE (logsMain.site LIKE '%api/alttimetables.%' OR logsMain.site LIKE '%api/news.%' OR site LIKE '%api/substitudes.%' OR logsMain.site LIKE '%api/timetables.%' OR logsMain.site LIKE '%api/allTimetables.%') AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."' group by logsMain.site";
$result = mysql_query($sql);
while($row[]=mysql_fetch_array($result)){
}
unset($row[count($row)-1]);
$sitesMobile = $row;	

foreach($browser_countPC as $b){
	$str1[]="['".$b[0]."',".$b[1]."]";
}

$str1 = implode(",",$str1);

foreach($browser_countM as $b){
	$str9[]="['".$b[0]."',".$b[1]."]";
}

$str9 = implode(",",$str9);

foreach($os_countM as $b){
	$str10[]="['".$b[0]."',".$b[1]."]";
}

$str10 = implode(",",$str10);


foreach($os_countPC as $b){
	$str2[]="['".$b[0]."',".$b[1]."]";
}

$str2 = implode(",",$str2);

foreach($classes as $b){
	$str3[]="['".$b[0]."',".$b[1]."]";
}
$str3 = implode(",",$str3);

foreach($sections as $b){
	$str4[]="['".$b[0]."',".$b[1]."]";
}
$str4 = implode(",",$str4);

foreach($sitesSub as $b){
	$str5[]="['".$b[0]."',".$b[1]."]";
}
$str5 = implode(",",$str5);

foreach($mobileWeb as $b){
	$str6[]="['".$b[0]."',".$b[1]."]";
}
$str6 = implode(",",$str6);

foreach($sitesClient as $b){
	$str7[]="['".$b[0]."',".$b[1]."]";
}
$str7 = implode(",",$str7);

foreach($sitesMobile as $b){
	$temp = explode( "/",$b[0]);
	$temp = $temp[3];
	$temp = explode(".",$temp);

	$str8[]="['".$temp[0]."',".$b[1]."]";
}
$str8 = implode(",",$str8);

$str[]=$str1;
$str[]=$str2;
$str[]=$str3;
$str[]=$str4;
$str[]=$str5;
$str[]=getHourFrequenzy($timeRelease);
$str[]=$str6;
$str[]=$str7;
$str[]=$str8;
$str[]=$str9;
$str[]=$str10;
$str[]=getDayFrequenzy($timeRelease);
$str[]=getFirstLastDay($timeRelease);

//echo $str;
return $str;
}

function getHourFrequenzy($timeRelease){

$sql = "SELECT logsMain.time FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$hour[]=date("G",$row[0]);
	$day[]=date("d.m.Y",$row[0]);
}

$hour = countDat($hour,"SORT_NUMERIC");
$day = count(countDat($day,"SORT_STRING"));
//print_R($hour);
foreach($hour as $i => $h){
	$str[] = "[".$h[0].",".round($h[1]/$day)."]";
}

return implode(",",$str);

}

function getDayFrequenzy($timeRelease){

$sql = "SELECT logsMain.time FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$day[]=strtotime(date("Y-m-d",$row[0]));
}

$day = countDat($day,"SORT_NUMERIC");

foreach($day as $i => $h){
	$str[] = "['".date("Y-m-d",$h[0])."',".$h[1]."]";
}

return implode(",",$str);

}

function getFirstLastDay($timeRelease){

$sql = "SELECT MIN(logsMain.time) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$min=mysql_fetch_array($result);

$sql = "SELECT MAX(logsMain.time) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsMain.time > '".$timeRelease."'";
$result = mysql_query($sql);
$max=mysql_fetch_array($result);

return array($min[0],$max[0]);

}

function countDat($dats,$sort){

if($sort == "SORT_STRING")
	array_multisort($dats,SORT_ASC, SORT_STRING);
else
	array_multisort($dats,SORT_ASC, SORT_NUMERIC);
$d_old="";
$i=0;
foreach($dats as $d){
	if($d_old==""){
		$i++;
	}
	else if($d == $d_old){
		$i++;
	}
	else if($d != $d_old){
		$d_count[]= array($d_old,$i);
		$i=1;
	}

	$d_old=$d;
}
$d_count[]= array($d_old,$i);

return $d_count;
}




?>
