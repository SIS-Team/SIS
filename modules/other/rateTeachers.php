<?php
	/* /modules/other/rateTeachers.php
	 * Autor: Buchberger Florian
	 * Version: 0.0.1
	 * Beschreibung:
	 *	Bewertet die Sinnhaftigkeit des Einsatzes von Supplierlehrern
	 *
	 */

	/*
	 * Basiswert ist 100
	 * 0     -> absolut ungeeignet
	 * 100   -> es spricht nichts dafür und nichts dagegen
	 * < 100 -> nicht perfekt, aber möglich
	 * > 100 -> ziemlich gut
	 *
	 * Berücksichtigt:
	 *	- Lehrer fehlt
	 *		: * 0
	 *	- Lehrer unterrichtet zur selben Zeit die selbe Klasse im selben Fach
	 *		: * 3
	 *	- Lehrer unterrichtet zur selben zeit eine andere Klasse
	 *		: * 0.1
	 *	- Lehrer hat keine Stunde am selben Tag
	 *		: * 0.5
	 *	
	 * TODO:
	 *	- Lehrer hat keine Mittagspause
	 *		+ Wenn Stunde zwischen 10:50 und 13:20
	 *		+ Wenn Anzahl der zuhaltenden Stunden des Lehrers an diesem Tag zwischen 
	 *		  10:50 und 12:20 > 2
	 *		: * 0.5
	 *	- Lehrer suppliert bereits eine andere Klasse zu dieser Zeit
	 *		: * 0.1
	 */

	function rateTeachers ($teacherId, $classId, $subjectId, $startHour, $endHour) {
		$base = 100;

		$sql = "SELECT * FROM missingTeachers 
			WHERE teacherFK=" . $TeacherId . " 
				AND StartDay<=" . date("Y-m-d") . " 
				AND endDay>=" . date("Y-m-d") . " 
				AND startHour<=" . $startHour . "
				AND endHour>=" . $endHour . "
				AND sure=1";
		$result1 = mysql_query($sql);

		$sql = "SELECT * FROM lessons 
				INNER JOIN lessonsBase ON lessons.lessonsBaseFK=lessonsBase.ID
			WHERE lessonsBase.startHourFK=" . $startHour . "
				AND lessonsBase.endHourFK=" . $endHour . "
				AND lessonsBase.classFK=" . $classId . "
				AND lessons.subjectFK=" . $subjectId . "
				AND lessons.teacherFK=" . $teacherId;
		$result2 = mysql_query($sql);

		$sql = "SELECT * FROM lessons 
				INNER JOIN lessonsBase ON lessons.lessonsBaseFK=lessonsBase.ID
			WHERE lessonsBase.startHourFK>=" . $startHour . "
				AND lessonsBase.endHourFK<=" . $endHour . "
				AND lessonsBase.classFK!=" . $classId . "
				AND lessons.teacherFK=" . $teacherId;
		$result3 = mysql_query($sql);

		$sql = "SELECT * FROM lessons
				INNER JOIN lessonsBase ON lessons.lessonsBaseFK=lessonsBase.ID
				INNER JOIN hours ON lessonsBase.startHourFK=hours.ID
			WHERE lessons.teacherFK=" . $teacherId . "
				AND hours.weekdayShort=(SELECT weekdayShort FROM hours WEHERE ID=" . $startHour . ")";
		$result4 = mysql_query($sql);


		if (mysql_num_rows($result1))
			$base *= 0;
		if (mysql_num_rows($result2))
			$base *= 3;
		if (mysql_num_rows($result3))
			$base *= 0.1;
		if (!mysql_num_rows($result3))
			$base *= 0.5;

		// TODO
		
		return $base;
	}
?>
