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
				login($_POST['user'], $_POST['password']);
				if (!isset($_GET['return']))
					$_GET['return'] = "./";
				header("LOCATION: " . $_GET['return']);
				exit();
			} catch (Exception $e) {
				$error = "<h2>: ( </h2> Irgendwas war falsch";
			}
		}
	}
	if (!$_SESSION['loggedIn']) {	
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo RELATIVE_ROOT; ?>/data/styles/menu.css" />
		<link rel="stylesheet" href="<?php echo RELATIVE_ROOT; ?>/data/styles/login.css" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="<?php echo RELATIVE_ROOT; ?>/favicon.ico" type="image/x-ico" rel="shortcut icon" />
		<script src="<?php echo RELATIVE_ROOT; ?>/data/scripts/miscellaneous.js"></script>
		<script>
			var checkMobile = function() {
				if (isMobile()) {
					window.location.href = "<?php echo RELATIVE_ROOT; ?>/mobile/";
					throw new Exception();
				}
			}
			<?php echo (!isset($_GET['noMobile'])) ? 'checkMobile();' : ''; ?>
		</script>
	</head>
	<body>
		<div id="allContainer">
			<div id="background">
			</div>
			<div id="headerCenter" class="point hCenter">
				<div id="header" class="sameWidth">
					<div id="title" class="link">
						<?php
							echo str_replace(" ", "<span> </span>", "SIS.Web Access");
						?>
					</div>
				</div>
			</div>
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

			<div id="footerCenter" class="point hCenter">
				<div id="footer" class="sameWidth link">
					<a href="<?php echo RELATIVE_ROOT; ?>/impressum/">Impressum</a> | <a href="<?php echo RELATIVE_ROOT; ?>/impressum/#privacy">Datenschutz</a> | <a href="<?php echo RELATIVE_ROOT; ?>/impressum/#terms">Nutzungsbedingungen</a> | <a href="<?php echo RELATIVE_ROOT; ?>/help/">Hilfe</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	} else {
		header("LOCATION: " . RELATIVE_ROOT . "/");
	}
?>
