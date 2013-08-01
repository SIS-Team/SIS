<?php

	/* /modules/database/selects.php
	 * Autor: Handle Marco
	 * Version: 0.3.0
	 * Beschreibung:
	 *	Select Befehle für die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *	0.2.0:  27. 07. 2013, Handle Marco - Erweiterungen der selects
	 *	0.3.0:	01. 08. 2013, Handle Marco - Ab�nderung der selects
	 */

/*
 *Gibt die Ganze Tabelle mit all ihren Spalten zurück
 *
 *$where string z.B. section='Elektronik'
 *$order string z.B. short
 *	
 */
 
function selectAll($table, $where, $order){

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sql="SELECT * FROM ".$table." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sql="SELECT * FROM ".$table." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql="SELECT * FROM ".$table." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sql="SELECT * FROM ".$table;

}

return mysql_query($sql);

}



function selectSection($where,$order){

$sql="SELECT sections.ID , sections.name as seName, teachers.short as teShort FROM sections INNER JOIN teachers ON sections.teacherFK=teachers.ID";

if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);



}

function selectRooms($where,$order){

$sql= "SELECT rooms.ID, rooms.name as roName, teachers.short as teShort FROM rooms INNER JOIN teachers ON rooms.teacherFK=teachers.ID";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}



function selectTeacher($where,$order){

$sql= "SELECT teachers.ID, teachers.name as teName, teachers.short as teShort, teachers.display, sections.name as seName FROM teachers INNER JOIN sections ON teachers.sectionFK=sections.ID";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectClass($where,$order){

$sql= "SELECT classes.ID, classes.name as clName, sections.name as seName, teachers.short as teShort, rooms.name as roName FROM classes INNER JOIN sections ON sections.ID=classes.sectionFK INNER JOIN teachers ON teachers.ID=classes.teacherFK INNER JOIN rooms ON rooms.ID=classes.classFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}


function selectLesson($where,$order){	//TODO

$sql= "SELECT lessons.ID, classes.name as clName, rooms.name as roName, teachers.short as teShort, subjects.short as suShort, days.short as daShort, lessons.hour, lessons.length FROM lessons INNER JOIN classes ON classes.ID=lessons.class INNER JOIN rooms ON rooms.ID=lessons.room INNER JOIN teachers ON teachers.ID=lessons.teachers INNER JOIN subjects ON subjects.ID=lessons.subject INNER JOIN days ON days.ID=lessons.day";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectMissingTeacher($where,$order){

  $sql= "SELECT missingTeachers.ID, teachers.short as teShort, missingTeachers.sDay, missingTeachers.sHour, missingTeachers.eDay, missingTeachers.eHour, missingTeachers.sure, missingTeachers.reason FROM missingTeachers INNER JOIN teachers ON teachers.ID = missingTeachers.teacherFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}


function selectMissingClass($where,$order){

  $sql= "SELECT missingClasses.ID, classes.name as clName, missingClasses.sDay, missingClasses.sHour, missingClasses.eDay, missingClasses.eHour, missingClasses.sure, missingClasses.reason FROM missingClasses INNER JOIN classes ON classes.ID = missingClasses.classFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectSubstitude($where,$order){	//TODO

  $sql= "SELECT substitudes.ID, subjects.short as suShort, teachers.short as teShort, substitudes.time, rooms.name as roName, substitudes.hour, substitudes.length, substitudes.hidden, substitudes.sure, substitudes.comment FROM substitudes INNER JOIN subjects ON subjects.ID = substitudes.subject INNER JOIN teachers ON teachers.ID = substitudes.teacher INNER JOIN rooms ON rooms.ID = substitudes.room";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectMonitor($where,$order){

  $sql= "SELECT monitors.ID, monitors.name, monitorMode.name as mode, monitors.file, rooms.name as roName FROM monitors INNER JOIN monitorMode ON monitorMode.ID = monitors.mode INNER JOIN rooms ON rooms.ID = monitors.roomFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine Einschränkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine Eischränkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}




?>