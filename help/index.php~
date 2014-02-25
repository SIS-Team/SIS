<?php

	/* /backend/missing/classes/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt die Formulare fuer die Eingabe der Fehlenden Klassen
	 *
	 * Changelog:
	 * 	0.1.0:  22. 07. 2013, Handle Marco - erste Version
	 *  0.2.0:  27. 08. 2013, Handle Marco - Update,Save,delete implementiert
	 */
	 
include("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung			
include_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		
include_once(ROOT_LOCATION . "/modules/form/hashGenerator.php");

$hashGenerator = new HashGenerator("MissingClasses", __FILE__);


if(!empty($_GET['send']) && $_GET['send']!=""){
	//HashCheck($hashGenerator);
	sendMail();
}


//Seitenheader
pageHeader("Hilfe/Fehlermeldung","main");
$hashGenerator->generate();

HashFail();

?>
<div style="">
<form>
<table>
<tr><td>E-Mail-Adresse<br /><input type="text" required name="email"></td></tr>
<tr><td>Text<br /><textarea required name="text" rows="7" cols="40"></textarea></td></tr>
<tr><td><input type="submit" name="send" value="Senden"></td></tr>
</table>
<form>
</div>

<?php


//Seitenfooter
pageFooter();

function sendMail(){

$empfaenger = "handle.marco@tele2.at";
$betreff = "Help/Fehler - SIS";
$from = "From: SIS <help@sis.htlinn.ac.at>\n";
$from.= "Content-Type: text/html\n";
$text = "
<html>
<body>
Hallo, <br /><br />

Der User: ".$_SESSION['name']." , ID: ".$_SESSION['id']." , Klasse: ".$_SESSION['class']." hat einen Frage bzw. einen Fehler zu melden. <br>
E-Mail : ".$_GET['email']."<br /><br />

".$_GET['text']."

</body>
</html>

";

mail($empfaenger,$betreff,$text,$from);


}


?>
