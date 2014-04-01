<?php
	/* /cookies/index.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.1
	 * Beschreibung:
	 *	Fragt den Benutzer, ob er Cookies erlaubt.
	 *
	 * Changelog:
	 * 	1.0.0:  22.06.2013, Buchberger Florian - erste Version
 	 * 	1.0.1:  28.01.2014, Philipp Machac - Ueberarbeitung Text
	 */
 	include_once("../config.php");
 	
	if (isset($_POST['okay'])) {
		setcookie("allowed", "true", time() + (60 * 60 * 24 * 100), "/"); // 100 Tage keine Abfrage
		header("LOCATION: " . $_POST['return']);
		die();
	}

	if (!isset($_GET['return']))
		$_GET['return'] = RELATIVE_ROOT;

	$_GET['return'] = str_replace("<", "", $_GET['return']);
	$_GET['return'] = str_replace(">", "", $_GET['return']);
	$_GET['return'] = str_replace("://", "", $_GET['return']);
	$_GET['return'] = str_replace("\"", "", $_GET['return']);
	$_GET['return'] = str_replace("'", "", $_GET['return']);

	include(ROOT_LOCATION . "/modules/general/Site.php");
	pageHeader("Cookies erlauben", "cookies");
?>
	<h1>Herzlich Willkommen bei SIS</h1>
	<p>
		Das School Information System (SIS) ist die Diplomarbeit einer Gruppe von Sch&uuml;lern der HTLinn, Abteilung Elektronik und Technische Informatik. <br />
		Ziel des Projektes ist es ein System zu entwerfen, welches Stundenpl&auml;ne, Supplierpl&auml;ne sowie News f&uuml;r Sch&uuml;ler und Lehrer elektronisch bereitstellt. Der Zugriff soll sowohl in Form dieses Portales, als auch mittels einer eigenen App f&uuml;r die bekanntesten Smartphoneplattformen m&ouml;glich sein. Au&szlig;erdem werden die Monitore, welche an diversen Stellen in der Schule montiert sind, mit diesem System angesteuert.
	</p>
	<br />
	<br />
	<p>
		Die EU schreibt vor, dass du als Benutzer dar&uuml;ber informiert wirst, wenn eine Seite Cookies verwendet. Die Cookies auf dieser Seite werden daf&uuml;r verwendet, dich als Sch&uuml;ler/Lehrer zu identifizieren.<br />
		Wenn du damit einverstanden bist, dass wir ein Session Cookie anlegen, so klicke einfach auf "Cookies erlauben".<br />
		Solltest du aber nicht einverstanden sein, so m&uuml;ssen wir dir leider die traurige Nachricht &uuml;berbringen, dass du diesen Service nicht verwenden kannst. 
	</p>
	<br />
	<form action="?" method="post">
		<input type="hidden" name="return" value="<?php echo $_GET['return']; ?>">
		<input type="hidden" name="okay" value="1">
		<input type="submit" value="Cookies erlauben  : )">
	</form>
<?php
	pageFooter();
?>
