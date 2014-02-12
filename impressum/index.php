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

Springe zu:
<ul>
	<li>
		<a href="#team" onclick="smoothScroll('team'); return false;">Projektteam</a>
	</li>
	<li>
		<a href="#advisors" onclick="smoothScroll('advisors'); return false;">Projektbetreuer</a>
	</li>
	<li>
		<a href="#source" onclick="smoothScroll('source'); return false;">Sourcecode</a>
	</li>
	<li>
		<a href="#privacy" onclick="smoothScroll('privacy'); return false;">Datenschutz</a>
	</li>
	<li>
		<a href="#terms" onclick="smoothScroll('terms'); return false;">Nutzungsbedingungen</a>
	</li>
</ul>

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

<hr />
<a name="team" id="team"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
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

<hr />
<a name="advisors" id="advisors"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h2>Projektbetreuer<h2>

<h3>Projektmanagement</h3>

WL. FOL. Dipl. Päd. DI (FH) Helmut STECHER<br />

<h3>Technischer Betreuer</h3>

Prof. Mag. Dr. Michael WEISS<br />

<h3>Serveradministration</h3>

Dipl. Päd. Ing. Wolfram LASSNIG<br />

<h3>Code-Review, etc.</h3>

VL Engelbert GRUBER<br />

<hr />
<a name="source" id="source"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Sourcecode</h1>

Der Sourcecode dieses Projekt ist vollständig offen und der 
<a target="_blank" href="http://www.gnu.org/licenses/gpl-2.0-standalone.html">GPLv2 (GNU Public License Version 2)</a>
<a target="_blank" href="<?php echo RELATIVE_ROOT; ?>/LICENSE">[alternativer Link]</a><br />
<br />

<a target="_blank" href="https://github.com/overflowerror/SIS">SIS auf github</a><br />

<h2>3rd Party Code</h2>

Für dieses Projekt wurden verschiedener Fremdcode verwendet.<br />
<ul>
	<li>
		<a target="_blank" href="http://www.fpdf.org/">FPDF</a> 
	</li>
	<li>
		<a target="_blank" href="http://www.itnewb.com/tutorial/Creating-the-Smooth-Scroll-Effect-with-JavaScript">Smooth-Scroll</a> <sup>1</sup>
	</li>
</ul>

<sup>1</sup>) Dieser Fremdcode wurde an die Gegebenheiten angepasst.

<hr />
<a name="privacy" id="privacy"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Datenschutz</h1>

Mach dir keine Hoffnungen, wir sind die NSA...<br />

// TODO <br />

<hr />
<a name="terms" id="terms"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Nutzungsbedingungen</h1>

Wir verwenden deine Daten... MUAHAHAHAHA... *hust*<br />

<?php
	pageFooter();
?>
