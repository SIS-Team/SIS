<?php

	/* /help/index.php
	 * Autor: Handle Marco
	 * Version: 0.2.0
	 * Beschreibung:
	 *	Erstellt das Formular für die Hilfe
	 *
	 */
	 
require("../config.php");
require_once(ROOT_LOCATION . "/modules/general/Main.php");				//Stellt das Design zur Verfügung			
require_once(ROOT_LOCATION . "/modules/form/hashCheckFail.php");		
require_once(ROOT_LOCATION . "/modules/form/HashGenerator.php");

$hashGenerator = new HashGenerator("Help", __FILE__);

if (!($_SESSION['loggedIn'])){
	header("Location: ".RELATIVE_ROOT."/");
	exit();
}

$email= "";
$betreff= "";
$text= "";
$cFail=false;
if(!empty($_POST['send']) && $_POST['send']!="" && $_POST['captcha']==$_SESSION['captcha']['code']){
	HashCheck($hashGenerator);
	sendMail();
}
else if(!empty($_POST['send']) && $_POST['send']!=""){
	$email= $_POST['email'];
	$betreff= $_POST['betreff'];
	$text= $_POST['text'];
	$text = str_replace("<", "&lt;", $text);
	$text = str_replace(">", "&gt;", $text);
	$cFail=true;
}

//Seitenheader
pageHeader("Hilfe/Fehlermeldung","main");
$hashGenerator->generate();

HashFail();

?>
<div style="">

<?php
if($cFail){
	echo "Falscher Code wurde eingegeben<br /><br />";
}
?>

<form method="post" >
	<?php $hashGenerator->printForm(); echo "\n";?>
	<table>
		<tr>
			<td>
				Deine E-Mail-Adresse<br />
				<input type="text" required name="email" value="<?php echo $email; ?>">
			</td>
		</tr>
		<tr>
			<td>
				Betreff<br />
				<input type="text" required name="betreff" value="<?php echo $betreff; ?>">
			</td>
		</tr>
		<tr>
			<td>
				Text<br /><textarea required name="text" rows="7" cols="40"><?php echo $text; ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<div id="captcha">
					<img src="<?php echo RELATIVE_ROOT; ?>/data/images/captcha.png" />
				</div>
				<div id="newCaptcha"></div>
			</td>
		</tr>
		<tr>
			<td>
				Zeichen eingeben:<br />
				<input type="text" required name="captcha">
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" name="send" value="Senden">
			</td>
		</tr>
	</table>
<form>
</div>
<script>
	document.getElementById("newCaptcha").innerHTML = '<input type="button" onclick="newCaptcha();" value="Anderer Captcha" />';
	function newCaptcha() {
		document.getElementById("captcha").getElementsByTagName("img")[0].src = "<?php echo RELATIVE_ROOT; ?>/data/images/loading.gif";
		window.setTimeout(function() {
			document.getElementById("captcha").getElementsByTagName("img")[0].src = "<?php echo RELATIVE_ROOT; ?>/data/images/captcha.png?preventCaching=" + parseInt((Math.random() * 100));
		}, 700)
	}
</script>
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
//echo 11;
mail($empfaenger,$betreff,$text,$from);


}


?>
