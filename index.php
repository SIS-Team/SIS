<?php
	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Main.php");

	include($_SERVER['DOCUMENT_ROOT'] . "/modules/general/Menu.php");
	generateDefaultMenu();


	pageHeader("Startseite", "main");
	if (!$_SESSION['loggedIn']) {
?>
Sie sind im Moment nicht angemeldet. Melden Sie sich jetzt an:
<div id="login">
	<form method="POST" action="login/?return=%2F">
		<table>
			<tr>
				<td>
					Benutzername: 
				</td>
				<td>
					<input type="text" name="user"><br />
				</td>
				<td>
					Passwort: 
				</td>
				<td>
					<input type="password" name="password"><br />
				</td>
			</tr>
		</table>
		<input type="submit" value="Absenden">
	</form>
</div>
<?php
	} else {
?>
<h1>Hallo <?php echo $_SESSION['name']; ?>!</h1><h2>Willkommen bei SIS</h2>
<?php
	}
	pageFooter();
?>
