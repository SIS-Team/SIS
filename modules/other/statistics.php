<?php

/* /modules/other/statistics.php
* Autor: Handle Marco,
*/

include_once("../../config.php");
include_once(ROOT_LOCATION."/modules/other/getBrowser.php");
include_once(ROOT_LOCATION."/modules/general/Connect.php");

function get(){

$sql = "SELECT logsSessions.userAgent FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){

	$temp=getBrowser($row[0]);
	$os[] = $temp["os"];
	$browser[] = $temp["name"];
}


for($i=1;$i<8;$i++){

$sql = "SELECT COUNT(classes.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK LEFT JOIN classes ON classes.ID = logsUsers.classesFK WHERE classes.name LIKE '".$i."%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsUsers.isTeacher='0'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$classes[]=array($i.". Jahrgang",$temp[0]);
}

$sql = "SELECT COUNT(logsUsers.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359' AND logsUsers.isTeacher='1'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$classes[]=array("Lehrer",$temp[0]);
$section = array('N','E','W','M');
foreach($section as $s){

$sql = "SELECT COUNT(sections.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK LEFT JOIN sections ON sections.ID = logsUsers.sectionsFK WHERE sections.short LIKE '".$s."' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sections[]=array($s." Abteilung",$temp[0]);
}

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%timetables%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Stundenplan/Modifiziert",$temp[0]);
$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%substitudes%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Supplierplan",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%mobile/api/substitudes%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$sitesSub[]=array("Supplierplan Mobil",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site LIKE '%mobile%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$mobileWeb[]=array("App",$temp[0]);

$sql = "SELECT COUNT(logsMain.ID) FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsMain.site NOT LIKE '%mobile%' AND logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
$temp = mysql_fetch_row($result);

if($temp[0]!=0)
	$mobileWeb[]=array("Web",$temp[0]);

$browser_count = countDat($browser,"SORT_STRING");
$os_count = countDat($os,"SORT_STRING");

foreach($browser_count as $b){
	$str1[]="['".$b[0]."',".$b[1]."]";
}

$str1 = implode(",",$str1);

foreach($os_count as $b){
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

$str[]=$str1;
$str[]=$str2;
$str[]=$str3;
$str[]=$str4;
$str[]=$str5;
$str[]=getHourFrequenzy();
$str[]=$str6;
//echo $str;
return $str;
}

function getHourFrequenzy(){

$sql = "SELECT logsMain.time FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$hour[]=date("G",$row[0]);
	$day[]=date("d.m.Y",$row[0]);
}

$hour = countDat($hour,"SORT_NUMERIC");
$day = count(countDat($day,"SORT_STRING"));

foreach($hour as $i => $h){
	$str[] = "[".$h[0].",".round($h[1]/$day)."]";
}

return implode(",",$str);

}

function getHourFrequenzy(){

$sql = "SELECT logsMain.time FROM logsMain LEFT JOIN logsUSConn ON logsUSConn.ID = logsMain.connFK LEFT JOIN logsSessions ON logsSessions.ID = logsUSConn.sessionFK LEFT JOIN logsUsers ON logsUsers.ID = logsUSConn.userFK WHERE logsUsers.LDAP!='20090334' AND logsUsers.LDAP!='20090319' AND logsUsers.LDAP!='20090340' AND logsUsers.LDAP!='20090396' AND logsUsers.LDAP!='20090359'";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$hour[]=date("G",$row[0]);
	$day[]=date("d.m.Y",$row[0]);
}

$hour = countDat($hour,"SORT_NUMERIC");
$day = count(countDat($day,"SORT_STRING"));

foreach($hour as $i => $h){
	$str[] = "[".$h[0].",".round($h[1]/$day)."]";
}

return implode(",",$str);

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
