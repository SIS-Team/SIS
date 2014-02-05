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

		if (mysql_num_rows($result1))
			$base *= 0;
		if (mysql_num_rows($result2))
			$base *= 3;
		if (mysql_num_rows($result3))
			$base *= 0.1;

		// TODO

	}
?>
