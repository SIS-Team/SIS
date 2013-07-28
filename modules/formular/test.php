<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Ohne_Titel_1</title>
</head>

<body>
<?php
include($_SERVER['DOCUMENT_ROOT'] . "/modules/formular/formular.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Connect.php");
include($_SERVER['DOCUMENT_ROOT'] . "/modules/database/selects.php");


$select = array(
	array( "test1", 	"Test1", 	""),
	array( "test2", 	"Test2", 	""),
	array( "test3", 	"Test3", 	""),
	);


$fields = array(
	array( "ID", 	"",			 	 "hidden", 	"",		"",	"",	""),
	array( "name", 	"Name: ", 		 "text", 	"10",	"",	"",	""),
	array( "short", "K&uuml;rzel: ", "text", 	"10",		"",	"",	""),		
	);

$result = selectAll("days","","ID DESC");
while ($row = mysql_fetch_array($result)){
	form_new("get","",$fields,$row);
}

form_new("get","",$fields,false);
?>



</body>

</html>
