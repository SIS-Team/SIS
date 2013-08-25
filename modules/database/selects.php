<?php

	/* /modules/database/selects.php
	 * Autor: Handle Marco
	 * Version: 0.5.0
	 * Beschreibung:
	 *	Select Befehle fÃƒÂ¼r die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *	0.2.0:  27. 07. 2013, Handle Marco - Erweiterungen der selects
	 *	0.3.0:	01. 08. 2013, Handle Marco - AbÃ¤nderung der selects
	 *	0.4.0:	23. 08. 2013, Handle Marco - Lessons Select
	 *	0.5.0	23. 08. 2013, Hanlde Marco - Selects fertigstellen
	 */

/*
 *Gibt die Ganze Tabelle mit all ihren Spalten zurÃƒÂ¼ck
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
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql="SELECT * FROM ".$table." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sql="SELECT * FROM ".$table;

}

return mysql_query($sql);

}



function selectSection($where,$order){

$sql="SELECT sections.ID , sections.name as seName, sections.short as seShort, teachers.short as teShort FROM sections INNER JOIN teachers ON sections.teacherFK=teachers.ID";

if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);



}

function selectRooms($where,$order){

$sql= "SELECT rooms.ID, rooms.name as roName, teachers.short as teShort FROM rooms LEFT JOIN teachers ON rooms.teacherFK=teachers.ID";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}



function selectTeacher($where,$order){

$sql= "SELECT teachers.ID, teachers.name as teName, teachers.short as teShort, teachers.display, sections.short as seShort FROM teachers LEFT JOIN sections ON teachers.sectionFK=sections.ID";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectClass($where,$order){

$sql= "SELECT classes.ID, classes.name as clName, sections.short as seShort, teachers.short as teShort, rooms.name as roName FROM classes LEFT JOIN sections ON sections.ID=classes.sectionFK LEFT JOIN teachers ON teachers.ID=classes.teacherFK LEFT JOIN rooms ON rooms.ID=classes.roomFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}


function selectLesson($where,$order){

  $sql= "SELECT lessons.ID, classes.name as clName, rooms.name as roName, teachers.short as teShort, subjects.short as suShort, hoursStart.weekdayShort as daShort, hoursStart.hour as startHour, hoursEnd.hour as endHour FROM lessons INNER JOIN rooms ON rooms.ID = lessons.roomFK INNER JOIN teachers ON teachers.ID = lessons.teachersFK INNER JOIN subjects ON subjects.ID = lessons.subjectFK INNER JOIN lessonsBase ON lessonsBase.ID = lessons.lessonBaseFK INNER JOIN classes ON classes.ID = lessonsBase.classFK INNER JOIN hours as hoursStart ON hoursStart.ID = lessonsBase.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = lessonsBase.endHourFK";

	echo "10";

//printf("%s,%s",$where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectMissingTeacher($where,$order){

  $sql= "SELECT missingTeachers.ID, teachers.short as teShort, missingTeachers.startDay as startDay, hoursStart.hour as startHour, missingTeachers.endDay as endDay, hoursEnd.hour as endHour, missingTeachers.sure, missingTeachers.reason FROM missingTeachers INNER JOIN teachers ON teachers.ID = missingTeachers.teacherFK INNER JOIN hours as hoursStart ON hoursStart.ID = missingTeachers.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = missingTeachers.endHourFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}


function selectMissingClass($where,$order){

  $sql= "SELECT missingClasses.ID, classes.name as clName, missingClasses.startDay as startDay, hoursStart.hour as startHour, missingClasses.endDay as endDay, hoursEnd.hour as endHour, missingClasses.sure, missingClasses.reason FROM missingClasses INNER JOIN classes ON classes.ID = missingClasses.classFK INNER JOIN hours as hoursStart ON hoursStart.ID = missingClasses.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = missingClasses.endHourFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}

function selectSubstitude($where,$order){	//TODO

  $sql= "SELECT substitudes.ID, subjects.short as suShort, teachers.short as teShort, substitudes.time, rooms.name as roName, hoursStart.hour as startHour, hoursEnd.hour as endHour, substitudes.hidden, substitudes.sure, substitudes.comment FROM substitudes INNER JOIN subjects ON subjects.ID = substitudes.subjectFK INNER JOIN teachers ON teachers.ID = substitudes.teacherFK INNER JOIN rooms ON rooms.ID = substitudes.roomFK INNER JOIN hours as hoursStart ON hoursStart.ID = substitudes.startHourFK INNER JOIN hours as hoursEnd ON hoursEnd.ID = substitudes.endHourFK";

//printf("%s,%s,%s",$table, $where, $order);
if($where!="" && $order!=""){		//Wenn beide Variablen beide gesetzt
	//echo "1";
	$sqlex=$sql." WHERE ".$where." ORDER BY ".$order;

}
else if($where!="" && $order==""){	//Wenn keine Sortierung vorhanden
	//echo "2";
	$sqlex=$sql." WHERE ".$where;
	
}
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
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
else if($where=="" && $order!=""){	//Wenn keine EinschrÃƒÂ¤nkung vorhanden
	//echo "3";
	$sql=$sql." ORDER BY ".$order;
	
}
else{	//Wenn keine EischrÃƒÂ¤nkung und Sortierung vorhanden
	//echo "4";
	$sqlex=$sql;

}

return mysql_query($sqlex);

}




?>