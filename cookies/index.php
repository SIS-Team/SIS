<?php
	/* /modules/general/ForceHTTPS.php
	 * Autor: Buchberger Florian
	 * Version: 1.0.0
	 * Beschreibung:
	 *	Fragt den Benutzer, ob er Cookies erlaubt.
	 *
	 * Changelog:
	 * 	1.0.0:  22.06.2013, Buchberger Florian - erste Version
	 */
	
	if (isset($_POST['okay'])) {
		setcookie("allowed", "true", time() + (60 * 60 * 24 * 100), "/"); // 100 Tage keine Abfrage
		header("LOCATION: " . $_POST['return']);
		die();
	}

	if (!isset($_GET['return']))
		$_GET['return'] = "/";

	$_GET['return'] = str_replace("<", "", $_GET['return']);
	$_GET['return'] = str_replace(">", "", $_GET['return']);
	$_GET['return'] = str_replace("://", "", $_GET['return']);
	$_GET['return'] = str_replace("\"", "", $_GET['return']);
	$_GET['return'] = str_replace("'", "", $_GET['return']);

	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Site.php");
	pageHeader("Cookies erlauben", "cookies");
?>
	<h1>Willkommen bei SIS</h1>
	<h2>School Information Service</h2>
	<p>
		SIS ist eine Diplomarbeit einer Gruppe von Sch&uuml;lern der HTL Peter Anich, Abteilung Elektronik. <br />
		Bei diesem Projekt geht es um ein System, das die Stundenpl&auml;ne, Supplierpl&auml;ne sowie die neuesten News f&uuml;r die HTL f&uuml;r die Sch&uuml;ler und Lehrer sch&ouml;n am Computer und Handy zur Verf&uuml;gung stellt. Als zus&auml;tzlicher Teil werden die Monitore, die in der Schule an verschiedenen Stellen angebracht werden, ebenfalls durch dieses System gemanaged.
	</p>
	<br />
	<br />
	<p>
		Die EU schreibt vor, dass wir Sie dar&uuml;ber informieren m&uuml;ssen, dass diese Seite Cookies verwendet. Diese Cookies werden dazu verwendet, Sie als Sch&uuml;ler/Lehrer zu identifizieren. So gesehen ist es nur logisch, aber Gesetz ist Gesetz...<br />
		Wenn Sie damit einverstanden sind, dass wir ein Session Cookie anlegen, so klicken Sie bitte auf "Cookies erlauben".<br />
		Sollten Sie aber nicht einverstanden sein, so k&ouml;nnen Sie gleich wieder gehen, denn diese Seite kann ohne die Speicherung der Session nicht funktionieren.
	</p>
	<br />
	<form action="?" method="post">
		<input type="hidden" name="return" value="<?php echo $_GET['return']; ?>">
		<input type="hidden" name="okay" value="1">
		<input type="submit" value="Cookies erlauben : )">
	</form>
<?php
	pageFooter();
?>
