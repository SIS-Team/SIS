<?php
	/* /login/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Login-Frontend
	 *
	 * Changelog:
	 * 	0.1.0:  15. 10. 2013, Buchberger Florian - erste Version
	 *	0.2.0:	03. 02. 2014, Machac Philipp - HTL-Background entfernt
	 */
	include("../config.php");
	include(ROOT_LOCATION . "/modules/general/Main.php");

	if (isset($_POST['user']) && isset($_POST['password'])) {
		if (trim($_POST['user']) != "" && trim($_POST['password']) != "") {
			try {
				sleep(0.2);
				login($_POST['user'], $_POST['password']);
				if (isset($_POST['keep']))
					$_SESSION['keep'] = true;
					
				if (!isset($_GET['return']))
					$_GET['return'] = "./";
				header("LOCATION: " . $_GET['return']);
				exit();
			} catch (Exception $e) {
				$error = "<h2>: ( </h2> Irgendwas war falsch";
			}
		} else {
			$error = "<h2>: ( </h2> Ein Feld war leer."
		}
	}
	if (!$_SESSION['loggedIn']) {
		pageHeader("Login", "supmain");
?>

<div class="point vCenter hCenter">
	<div id="login">
		<h1>Login</h1>
		<?php	
			if (isset($error))
				echo '<div class="error">' . $error . "</div>";
		?>
		<form action="?return=<?php echo (isset($_GET['return'])) ? urlencode($_GET['return']) : urlencode("./"); ?>" method="post">
			<hr />					
			<?php include(ROOT_LOCATION . "/data/images/login/user.svg"); ?>
			<input title="Bitte verwendet eure Novell-Credentials ohne Punkte, ohne Kontext, z.B:
2001234 und das Novell Passwort." placeholder="Benutzername" type="text" name="user" autofocus>
			<hr />
			<?php include(ROOT_LOCATION . "/data/images/login/pass.svg"); ?>
			<input placeholder="Kennwort" type="password" name="password">
			<hr />
			<input type="checkbox" name="keep">Angemeldet bleiben
			<div id="send">
				<input type="submit" value="Anmelden">
			</div>
		</form>
	</div>
</div>
<?php
		pageFooter();
	} else {
		header("LOCATION: " . RELATIVE_ROOT . "/");
	}
?>
