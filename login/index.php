<?php
	/* /login/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Login-Frontend
	 *
	 * Changelog:
	 * 	0.1.0:  15. 10. 2013, Buchberger Florian - erste Version
	 */
	include("../config.php");
	include(ROOT_LOCATION . "/modules/general/Main.php");

	if (isset($_POST['user']) && isset($_POST['password'])) {
		if (trim($_POST['user']) != "" && trim($_POST['password']) != "") {
			try {
				login($_POST['user'], $_POST['password']);
				if (!isset($_GET['return']))
					$_GET['return'] = "./";
				header("LOCATION: " . $_GET['return']);
				exit();
			} catch (Exception $e) {
				$error = "<h1>: (</h1><h2>Benutzername oder Passwort falsch</h2>" . $e->getMessage();
			}
		}
	}

	include(ROOT_LOCATION . "/modules/general/Menu.php");

	pageHeader("Login", "main");
	if (!$_SESSION['loggedIn']) {	
		if (isset($error))
			echo $error;
?>
<form action="?return=<?php echo (isset($_GET['return'])) ? urlencode($_GET['return']) : urlencode("./"); ?>" method="post">
	<input type="text" name="user"><br />
	<input type="password" name="password"><br />
	<input type="submit">
</form>
<?php
	} else {
?>
<h1>Sie sind nun angemeldet... : )</h1>
<?php
	}
	pageFooter();
?>
