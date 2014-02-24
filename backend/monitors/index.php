<?php

	/* /backend/monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.1
	 * Beschreibung:
	 *	Erstellt die Formulare für die Eingabe der Monitore
	 *
	 * Changelog:
	 *	1.0.1:	24. 09. 2013, Buchberger Florian - IP-Adressen werden angezeigt
	 * 	1.0.0:	20. 09. 2013, Buchberger Florian - erste vollständige Version
	 * 	0.1.0:  09. 09. 2013, Buchberger Florian - neue Version
	 */

	include_once("../../config.php");
	include_once(ROOT_LOCATION . "/modules/general/Main.php");
	include_once(ROOT_LOCATION . "/modules/monitors/Main.php");
	include_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");
	
	$hashGenerator = new HashGenerator("monitor-form", __FILE__);

	if (!$_SESSION['loggedIn'])
		exit();
	if (!($_SESSION['rights']['root'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['E'] || $_SESSION['rights']['M']))
		exit();

	// Wenn das Fomular abgeschickt wird
	if (isset($_POST['sent'])) {
		try {
			$hashGenerator->check();
		} catch (Exception $e) {
			header("LOCATION: ?error=7");
			exit();
		}

		// Tests, ob alle Parameter vorhanden sind.
		if (!isset($_POST['monitors'])) {
			header("LOCATION: ?error=1");
			exit();
		}
		if (!isset($_POST['room'])) {
			header("LOCATION: ?error=2");
			exit();
		}
		if (!isset($_POST['mode'])) {
			header("LOCATION: ?error=3");
			exit();
		}

		$query = "";

		// Wenn die Löschen-Checkbox gesetzt ist, dann Query auf Delete setzen.
		if (isset($_POST['delete']))
			$query .= "DELETE FROM `monitors` WHERE `id`=";
		// Sonst Query auf Update setzen
		else {
			$query .= "UPDATE `monitors` SET ";

			if (!empty($_POST['text'])) {
				$query .= "`text`='" . mysql_real_escape_string(htmlspecialchars($_POST['text'])) . "' ";
				if (!empty($_POST['room']) || !empty($_POST['section']) || !empty($_POST['mode']) || !empty($_FILES['file']['name']) || !empty($_POST['displayMode']) || !empty($_POST['displayOff']) || !empty($_POST['displayOn']))
					$query .= ", ";
			}
			
			// Wenn Raum-Feld nicht leer, dann Raum ID holen und Query mit Raum ergänzen
			if (!empty($_POST['room'])) {
				$id = mysql_fetch_object(mysql_query("SELECT `ID` FROM `rooms` WHERE `name`='" . mysql_real_escape_string($_POST['room']) . "'"))->ID;
				$query .= "`roomFK`=" . $id . " ";
				if (!empty($_POST['section']) || !empty($_POST['mode']) || !empty($_FILES['file']['name']) || !empty($_POST['displayMode']) || !empty($_POST['displayOff']) || !empty($_POST['displayOn']))
					$query .= ", ";
			}

			if (!empty($_POST['section'])) {
				$id = mysql_fetch_object(mysql_query("SELECT `ID` FROM `sections` WHERE `name`='" . mysql_real_escape_string($_POST['section']) . "'"))->ID;
				$query .= "`sectionFK`=" . $id . " ";
				if (!empty($_POST['mode']) || !empty($_FILES['file']['name']) || !empty($_POST['displayMode']) || !empty($_POST['displayOff']) || !empty($_POST['displayOn']))
					$query .= ", ";
			}
			
			// Wenn Modus-Feld nicht leer, dann Modus ID holen und Query mit Modus ergänzen
			if (!empty($_POST['mode'])) {
				$id = mysql_fetch_object(mysql_query("SELECT `ID` FROM `monitorMode` WHERE `name`='" . mysql_real_escape_string($_POST['mode']) . "'"))->ID;
				$query .= "`modeFK`=" . $id . " ";
				if (!empty($_FILES['file']['name']) || !empty($_POST['displayMode']) || !empty($_POST['displayOff']) || !empty($_POST['displayOn']))
					$query .= ", ";
			}

			if (!empty($_POST['displayMode'])) {
				$id = mysql_fetch_object(mysql_query("SELECT `ID` FROM `displayMode` WHERE `name`='" .  mysql_real_escape_string($_POST['displayMode']) ."'"))->ID;
				$query .= "`displayModeFK`=" . $id . " ";
				if (!empty($_FILES['file']['name']) || !empty($_POST['displayOff']) || !empty($_POST['displayOn']))
					$query .= ", ";
                        }

			if (!empty($_POST['displayOn'])) {
				$array = explode(":", $_POST['displayOn']);
				for ($i = count($array); $i < 3; $i++)
					$array[$i] = 0;
				$array = array_splice($array, 0, 3);
				for ($i = 0; $i < 3; $i++)
					$array[$i] = intval($array[$i]);
				$time = mktime($array[0], $array[1], $array[2]);
				$query .= "`displayStartDaytime`=" . $time . " ";
				if (!empty($_FILES['file']['name']) || !empty($_POST['displayOff']))
					$query .= ", ";
			}

			if (!empty($_POST['displayOff'])) {
				$array = explode(":", $_POST['displayOff']);
				for ($i = count($array); $i < 3; $i++) 
					$array[$i] = 0;
				$array = array_splice($array, 0, 3);
				for ($i = 0; $i < 3; $i++)
					$array[$i] = intval($array[$i]);
				$time = mktime($array[0], $array[1], $array[2]);
				$query .= "`displayEndDaytime`=" . $time . " ";
				if (!empty($_FILES['file']['name']))
					$query .= ", ";
			}



			// Wenn die mitgegebene Datei einen Namen hat, dann 
			// 	wenn Datei zu groß -> Fehlermeldung
			//	wenn keine Rechte im Zielverzeichnis (../../monitors/media/) -> Fehlermeldung
			//	Dateinamen maskieren und mit Zeit ergänzen (gegen Kollisionen)
			//	Datei verschieben
			//	Query mit Dateinamen ergänzen
			if (!empty($_FILES['file']['name'])) {
				if ($_FILES['file']['size'] > 800 * 1024 * 1024) {
					header("LOCATION: ?error=4");
					die();
				}
				if ($_FILES['file']['size'] == 0) {
					header("LOCATION: ?error=6");
					die();
				}
				$filename = time() . "-" . mysql_real_escape_string(sanitize($_FILES['file']['name']));
				if (!move_uploaded_file($_FILES['file']['tmp_name'], "../../monitors/media/" . $filename)) {
					header("LOCATION: ?error=5");
					die();
				}
				$query .= "`file`='" . $filename . "' ";
			}
			$query .= "WHERE `id`=";
		}

		// Monitor-Liste hole und den generierten Query für jeden Monitor anwenden
		$monitors = $_POST['monitors'];
		for ($i = 0; $i < count($monitors); $i++) {
			$num = intval($monitors[$i]);
			mysql_query($query . $num);
		}
		header("LOCATION: ?sent");
		die();
	}
	
	pageHeader("Monitore", "main");

	// Error-Code-Handler, interpretiert Error-Code und gibt Fehlermeldung aus
	if (isset($_GET['error'])) {
		echo '<div class="error">';
		switch ($_GET['error']) {
		case 1:
			echo "Sie m&uuml;ssen mindestens einen Monitor ausw&auml;hlen.";
			break;
		case 2:
			echo "Ung&uuml;ltiger Raum.";
			break;
		case 3:
			echo "Ung&uuml;ltiger Modus.";
			break;
		case 4:
			echo "Datei zugro&szlig;!";
			break;
		case 5:
			echo "Es ist ein schwerer interner Fehler aufgetreten!";
			break;
		case 6:
			echo "Die hochgeladene Datei ist gr&ouml;&azlig;er, als die Maximal-Definition in php.ini. Bitte wenden Sie sich an den Administrator.";
			break;
		case 7:
			echo "Das Formular ist nicht mehr aktuell! Bitte versuchen Sie es sp&auml;ter wieder.";
		default:
			echo "Unbekannter Fehler: " . htmlspecialchars($_GET['error']);
			break;
		}
		echo '</div><br />';
	}

	if (isset($_GET['sent'])) {
?>
<div class="message">
	Die &Aumlnderungen wurden erfolgreich gespeichert.
</div>
<?php
	}

	// Alle Parameter holen
	$monitors = getAllMonitors();	
	echo mysql_error();
	$rooms = mysql_query("SELECT `name` FROM `rooms`");
	$modes = mysql_query("SELECT `name` FROM `monitorMode`");
	$displayModes = mysql_query("SELECT `name` FROM `displayMode`");
	$sections = mysql_query("SELECT `name` FROM `sections`");
	
	$hashGenerator->generate();
?>
<form action="?" method="post" enctype="multipart/form-data">
<?php
	$hashGenerator->printForm();
?>
	<datalist id="rooms">
<?php
	// alle Möglichkeiten für die Räume in eine Datalist schreiben
	while ($room = mysql_fetch_object($rooms)) {
		echo "		<option value=\"" . $room->name . "\"></option>";
	}
?>
	</datalist>
	<datalist id="sections">
<?php
	// alle Möglichkeiten für die Räume in eine Datalist schreiben
	while ($section = mysql_fetch_object($sections)) {
		echo "		<option value=\"" . $section->name . "\"></option>";
	}
?>
	</datalist>
	<datalist id="modes">
<?php
	// alle Möglichkeiten für die Modi in eine Datalist schreiben
	while ($mode = mysql_fetch_object($modes)) {
		echo "		<option value=\"" . $mode->name . "\"></option>";
	}
?>
	</datalist>
	<datalist id="displayModes">
<?php
	// alle Möglichkeiten für die Modi in eine Datalist schreiben
	while ($mode = mysql_fetch_object($displayModes)) {
		echo "          <option value=\"" . $mode->name . "\"></option>";
	}
?>
	</datalist>
	<script src="<?php echo RELATIVE_ROOT; ?>/data/scripts/monitorsInput.js"></script>
	<input type="button" onclick="invertSelection(); return false;" value="Auswahl invertieren"></input><br />
	<table>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Text</th>
			<th>Raum</th>
			<th>Abteilung</th>
			<th>Modus</th>
			<th>Datei</th>
			<th>erstellt von</th>
			<th>am</th>
			<th>Monitor-Steuerung</th>
		</tr>
<?php
	// Monitor-Tabelle ausgeben
	while ($monitor = mysql_fetch_object($monitors)) {
		echo "	<tr>";
		echo "		<td><input class=\"checkbox\" name=\"monitors[]\" value=\"" . $monitor->id . "\" type=\"checkbox\" /></td>";
		echo "		<td>" . htmlspecialchars($monitor->name) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->text) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->room) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->sectionShort) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->type) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->file) . "</td>";
		echo "		<td>" . htmlspecialchars($monitor->ip)   . "</td>";
		echo "		<td>" . date("d. m. Y", $monitor->regTime) . "</td>";
		echo "		<td>" . (($monitor->displayMode == "permanent Ein") ? "immer ein" : (($monitor->displayMode == "permanent Aus") ? "immer aus" : ("ein zwischen " . date("G:i:s", $monitor->startTime) . " und " . date("G:i:s", $monitor->endTime)))) . "</td>";
		echo "	</tr>";
	}
?>
	</table>
	<br />
	<table>
		<tr>
			<td>Text: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" name="text" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Raum: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="rooms" name="room" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Abteilung: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="sections" name="section" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Modus: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="modes" name="mode" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Datei: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="file" name="file" maxlength="800000000" accept="image/jpeg image/gif image/png video/mpeg" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Display-Modus: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="displayModes" name="displayMode" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Einschalt-Zeit (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" name="displayOn" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Ausschalt-Zeit (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" name="displayOff" style="width: 100%"></td>
		</tr>
		<tr>
			<td>L&ouml;schen? </td>
			<td><input type="checkbox" name="delete"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Absenden" style="width: 100%">
				<input type="hidden" value="1" name="sent">
			</td>
		</tr>
	</table>
</form>
<?php

	pageFooter();

?>
