<?php

	/* /help/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt das Formular für die Hilfe
	 *
	 */
	 
include("../config.php");
include_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung
include_once(ROOT_LOCATION . "/modules/form/form.php");					//Stell die Formularmasken zur Verfügung			
include_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		
include_once(ROOT_LOCATION . "/modules/form/hashGenerator.php");

$hashGenerator = new HashGenerator("Help", __FILE__);

if (!($_SESSION['loggedIn'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}


if(!empty($_POST['send']) && $_POST['send']!=""){
	HashCheck($hashGenerator);
	sendMail();
}


//Seitenheader
pageHeader("Hilfe/Fehlermeldung","main");
$hashGenerator->generate();

HashFail();

?>
<div style="">
<form method="post" >
<table>
<?php $hashGenerator->printForm(); echo "\n";?>
<tr><td>Deine E-Mail-Adresse<br /><input type="text" required name="email"></td></tr>
<tr><td>Betreff<br /><input type="text" required name="betreff"></td></tr>
<tr><td>Text<br /><textarea required name="text" rows="7" cols="40"></textarea></td></tr>
<tr><td><input type="submit" name="send" value="Senden"></td></tr>
</table>
<form>
</div>

<?php


//Seitenfooter
pageFooter();

function sendMail(){

$empfaenger = "SIS-Team@htlinn.ac.at";
$betreff = htmlspecialchars($_POST['betreff']);
$from = "From: SIS <help@sis.htlinn.ac.at>\n";
$from.= "Content-Type: text/html\n";
$text = "
<html>
<body>
Hallo, <br /><br />

Der User: ".$_SESSION['name']." , ID: ".$_SESSION['id']." , Klasse: ".$_SESSION['class']." hat einen Frage bzw. einen Fehler zu melden. <br>
E-Mail : ".htmlspecialchars($_POST['email'])."<br /><br />

".htmlspecialchars($_POST['text'])."

</body>
</html>

";

mail($empfaenger,$betreff,$text,$from);


}


?>
