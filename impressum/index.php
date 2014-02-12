<?php
	/* /impressum/index.php
	 * Autor: Buchberger Florian
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Impressum
	 */	 
	include("../config.php");
	include_once(ROOT_LOCATION . "/modules/general/Main.php");

	pageHeader("Impressum","main");
	
?>
<a name="top" id="top"></a>
Höhere Technische Bundes Lehr- und Versuchsanstalt Anichstraße<br />
Anichstraße 26 - 28<br />
A-6020 Innsbruck<br />
<br />
<table>
	<tr>
		<td>
			Telefon
		</td>
		<td>
			+43 - (0) 512 - 59717 - 0
		</td>
	</tr>
	<tr>
		<td>
			Fax
		</td>
		<td>
			+43 - (0) 512 - 59717 - 72
		</td>
	</tr>
	<tr>
		<td>
			E-Mail
		</td>
		<td>
			<a href="mailto:direction@htlinn.ac.at">
				direction@htlinn.ac.at
			</a>
		</td>
	</tr>
	<tr>
		<td>
			Sekretariat
		</td>
		<td>
			Anichstraße 26, 1.Stock, Raum 102
		</td>
	</tr>
</table>
<br />
<h2>Direktor</h2>

Mag. Günther LANER<br />
Telefon: +43 (0) 512 - 59717 - 10<br />

<h2>Projektteam</h2>

Florian BUCHBERGER<br />
Zuständig für:<br />
<ul>
	<li>
		Basissystem (+ Monitorbasis)
	</li>
	<li>
		Datenbank
	</li>
	<li>
		LDAP-Authentifizierung
	</li>
	<li>
		Designimplementierung
	</li>
	<li>
		Raspberry Software Konfiguration
	</li>
</ul><br />

Marco HANDLE<br />
Zuständig für:<br />
<ul>
	<li>
		Eingabensystem
	</li>
	<li>
		Datenbank
	</li>
	<li>
		Raspberry Hardware Setup
</ul><br />

Matthias Klotz<br />
Zuständig für:<br />
<ul>
	<li>
		App
	</li>
	<li>
		Raspberry Hardware Setup
	</li>
</ul><br />

Mathias WEILAND<br />
Zuständig für:<br />
<ul>
	<li>
		Newssystem
	</li>
	<li>
		Ausgabe Supplierplan
	</li>
	<li>
		Ausgabe Stundenplan
	</li>
</ul><br />

<h3>Sonstige Mitarbeiter</h3>

Philipp MACHAC<br />
Zuständig für:<br />
<ul>
	<li>
		Design
	</li>
</ul><br />

<h2>Projektbetreuer<h2>

<h3>Projektmanagement</h3>

WL. FOL. Dipl. Päd. DI (FH) Helmut Stecher<br />

<h3>Technischer Betreuer</h3>

Prof. Mag. Dr. Michael WEISS<br />

<h3>Serveradministration</h3>

Dipl. Päd. Ing. Wolfram LASSNIG<br />

<h3>Code-Review, etc.</h3>

VL Engelbert GRUBER<br />

<h1>Source Code</h1>

Wenn es dich interessiert: <a href="https://github.com/overflowerror/SIS">SIS auf github</a><br />

<a name="privacy" id="privacy"></a>
<h1>Datenschutz</h1>

Mach dir keine Hoffnungen, wir sind die NSA...<br />

// TODO <br />

<a name="terms" id="terms"></a>
<h1>Nutzungsbedingungen</h1>

Wir verwenden deine Daten... MUAHAHAHAHA... *hust*<br />

<?php
	pageFooter();
?>
