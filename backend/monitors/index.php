<?php

	/* /backend/monitors/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Erstellt die Formulare für die Eingabe der Monitore
	 *
	 * Changelog:
	 * 	0.1.0:  09. 09 2013, Buchberger Florian - neue Version
	 */

	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");
	include_once($_SERVER['DOCUMENT_ROOT'] . "/modules/monitors/Main.php");
	pageHeader("Monitore", "main");

	$monitors = getAllMonitors();
	$rooms = mysql_query("SELECT `name` FROM `rooms`");
	$modes = mysql_query("SELECT `name` FROM `monitorMode`");
?>
<form action="?" method="post" enctype="multipart/form-data">
	<datalist id="rooms">
<?php
	while ($room = mysql_fetch_object($rooms)) {
		echo "		<option value=\"" . $room->name . "\"></option>";
	}
?>
	</datalist>
	<datalist id="rooms">
<?php
	while ($modes = mysql_fetch_object($modes)) {
		echo "		<option value=\"" . $modes->name . "\"></option>";
	}
?>
	</datalist>
	<table>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Raum</th>
			<th>Modus</th>
			<th>Datei</th>
		</tr>
<?php
	while ($monitor = mysql_fetch_object($monitors)) {
		echo "	<tr>";
		echo "		<td><input name=\"m" . $monitor->id . "\" type=\"checkbox\"></td>";
		echo "		<td>" . $monitor->name . "</td>";
		echo "		<td>" . $monitor->room . "</td>";
		echo "		<td>" . $monitor->type . "</td>";
		echo "		<td>" . $monitor->file . "</td>";
		echo "	</tr>";
	}
?>
	</table>
	<br />
	<table>
		<tr>
			<td>Raum: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="rooms" name="room" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Modus: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="text" autocomplete="off" list="modes" name="modes" style="width: 100%"></td>
		</tr>
		<tr>
			<td>Datei: (leer f&uuml;r unver&auml;ndert) </td>
			<td><input type="file" name="file" maxlength="800000000" accept="image/jpeg image/gif image/png video/mpeg" style="width: 100%"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Absenden" style="width: 100%">
			</td>
		</tr>
	</table>
</form>
<?php

	pageFooter();

?>
