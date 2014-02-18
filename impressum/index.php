<?php
	/* /impressum/index.php
	 * Autor: Buchberger Florian
	 * Version: 1.1.0
	 * Beschreibung:
	 *	Impressum
	 *
	 * Changelog:
	 * 	1.0.0:  18.02.2014, Machac Philipp - Fehler behoben und Datenschutz added
	 *	1.1.0:	18.02.2014, Machac Philipp - Datenschutz improved
	 */	 
	include("../config.php");
	include_once(ROOT_LOCATION . "/modules/general/Main.php");

	pageHeader("Impressum","main");
	
?>

<a name="navigation" id="navigation"></a>

<h1>Navigation</h1>
<ul>
	<li>
		<a href="#responsible" onclick="smoothScroll('responsible'); return false;">Für den Inahlt dieser Website verantwortlich</a>
	</li>
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
		<a href="#privacy" onclick="smoothScroll('privacy'); return false;">Datenschutzbestimmungen</a>
	</li>
	<li>
		<a href="#terms" onclick="smoothScroll('terms'); return false;">Nutzungsbedingungen</a>
	</li>
</ul>
<br />

<hr />
<a name="responsible" id="responsible"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>

<h1>Für den Inhalt dieser Website verantwortlich</h1>

Höhere Technische Bundes Lehr- und Versuchsanstalt Anichstraße<br />
Anichstraße 26 - 28<br />
A-6020 Innsbruck<br />
<br />
<table>
	<tr>
		<td>
			Telefon:
		</td>
		<td>
			+43 - (0) 512 - 59717 - 0
		</td>
	</tr>
	<tr>
		<td>
			Fax:
		</td>
		<td>
			+43 - (0) 512 - 59717 - 72
		</td>
	</tr>
	<tr>
		<td>
			E-Mail:
		</td>
		<td>
			<a href="mailto:direktion@htlinn.ac.at">
				direktion@htlinn.ac.at
			</a>
		</td>
	</tr>
	<tr>
		<td>
			Sekretariat:
		</td>
		<td>
			Anichstraße 26, 1.Stock, Raum 102
		</td>
	</tr>
</table>
<br />
<h2>Direktor</h2>

Mag. Günther LANER<br />
<table>
	<tr>
		<td>
			Telefon:
		</td>
		<td>
			+43 - (0) 512 - 59717 - 10
		</td>
	</tr>
</table><br />

<hr />
<a name="team" id="team"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Projektteam</h1>

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

Matthias KLOTZ<br />
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
</ul>

<h2>Sonstige Mitarbeiter</h2>

Philipp MACHAC<br />
Zuständig für:<br />
<ul>
	<li>
		Grafiken und Design
	</li>
	<li>
		Datenschutzbestimmungen und Nutzungsbedingungen
	</li>
</ul><br />

<hr />
<a name="advisors" id="advisors"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Projektbetreuer<h1>

<h2>Projektmanagement</h2>

WL. FOL. Dipl. Päd. DI (FH) Helmut STECHER<br />

<h2>Technischer Betreuer</h2>

Prof. Mag. Dr. Michael WEISS<br />

<h2>Serveradministration</h2>

Dipl. Päd. Ing. Wolfram LASSNIG<br />

<h2>Code-Review, etc.</h2>

VL Engelbert GRUBER<br /><br />

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

<sup>1</sup>) Dieser Fremdcode wurde an die Gegebenheiten angepasst.<br /><br />

<hr />
<a name="privacy" id="privacy"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Datenschutzbestimmungen</h1>

Persönlichkeitsrechte und der Schutz deiner Daten sind uns wichtig. Deshalb möchten wir dir im nachfolgenden Text 
erläutern welche Daten wir von dir als Benutzer von SIS erheben und wie wir diese weiterverwenden, um die Dienste, 
welche wir mit diesem Service zur Verfügung stellen, weiter verbessern zu können.<br /><br />
Obwohl wir uns um eine möglichst einfache Darstellung bemüht haben, kann es vorkommen, dass dir Begriffe wie Cookies, 
Sessions, IP-Adresse, Browser oder OS nicht vertraut sind. In diesem Fall bitten wir dich darum, dich zunächst über 
diese Begriffe zu informieren.<br /><br />
Solltest du noch weitere Fragen bezüglich des Datenschutzes bei SIS haben, kontaktiere uns bitte unter 
	<a href="mailto:SIS-Development@htlinn.ac.at">
			SIS-Development@htlinn.ac.at
	</a>
<br /><br />
<h2>Erheben und Nutzen von personenbezogenen Daten</h2>

Personenbezogene Daten sind Daten, welche dazu verwendet werden können, eine Person eindeutig zu identifizieren.<br /><br />
Bevor wir dir in der nachfolgenden Aufzählung die von uns erhobenen personenbezogenen Daten aufschlüsseln ist es allerdings 
wichtig zu erwähnen, dass wir Daten nur dann Speichern, wenn du angemeldet bist. Von uns gespeicherte Daten werden 
ausschließlich für Statistiken verwendet. <br /><br />
Bereits bevor du dich allerdings anmelden kannst, nämlich dort, wo du der Erstellung eines Session Cookies zugestimmt hast wird 
diese zwar angelegt, jedoch werden zu diesem Zeitpunkt keine mit dir verbundenen Daten gespeichert.<br /><br />

<h3>Welche personenbezogenen Daten wir erheben</h3>

<ul>
	<li>
		Einige wichtige Informationen über dich liefert uns der HTTP User Agent. Darin sind im Wesentlichen 
		Daten über dein verwendetes Device enthalten. Wir erfahren dadurch z.B. ob es sich bei deinem Gerät um einen 
		Desktop PC oder um ein Mobilgerät handelt, welches OS auf diesem Gerät verwendet wird (z.B. Windows 7, iOS 7, 
		Android 3.2 usw.) und welchen Browser in welcher Version du nützt, um 
		<a href="https://sis.htlinn.ac.at">https://sis.htlinn.ac.at </a>aufzurufen.
	</li>
	<li>
		Neben der Session-ID, welche uns als Identifikationsmerkmal dient, um mehrere zusammengehörige Anfragen von dir 
		als Benutzer zu erkennen und deiner Session (=Sitzung) zuordnen zu können, erheben wir auch deine IP-Adresse, 
		alle deine Logins (Datum, Uhrzeit) sowie deine Bewegung innerhalb der SIS Website.
	</li>
	<li>
		Die Daten des HTTP User Agents, deine Login Daten und deine Seitenaufrufe sind zwar alle eindeutig deiner Session 
		zuzuordnen, jedoch ist es damit nicht möglich, sie dir persönlich zuzuordnen. Selbst die IP-Adresse ermöglicht es uns nicht, 
		dich eindeutig zu identifizieren, da du diese von deinem Internet Serviceprovider nur für eine oftmals kurze Zeit 
		zugeordnet bekommst, bevor diese wechselt.
		<br /> Und von deinem Provider zu erfahren wann du welche IP hattest, ist ohne Gerichtsbeschluss nicht möglich. <br /> 
		Deshalb erfassen wir noch deine LDAP-ID, also deine schulinterne, eindeutige Identifikationsnummer. 
		Neben der ID werden auch noch deine Abteilung sowie deine Klasse gespeichert.
	</li>
</ul>

<h3>Wie wir personenbezogene Daten nutzen</h3>

<ul>
	<li>
		Vom HTTP User Agent gelieferte Daten werden Beispielsweise dazu verwendet, dir beim Zugriff mittels mobile 
		Device (Smartphone oder Tablet) eine angepasste Startseite anzuzeigen, welche dir sofort die Möglichkeit eröffnet,
		unsere mobile SIS-App aus den jeweiligen AppStores herunterzuladen. <br />
		Neben dieser Nutzung der Daten, welche den Inhalt für dich zu deinem Vorteil anpasst, verwenden wir die User Agent
		Daten auch für unsere Statistiken.
	</li>
	<li>
		Alle anderen Daten (Login, Seitenaufrufe, ID, Klassen, Abteilungen usw.) werden ausschließlich für Statistiken 
		verwendet. Beispiele für Statistiken können sein: <br />
		Nutzungsstatistiken von Betriebssystemen und Browsern, Abteilungen sowie Nutzungsstatistiken der 
		verschiedenen Altersstufen.
	</li>
</ul>

<h2>Weitergabe an Dritte</h2>

Von uns gespeicherte Daten werden ausschließlich für Statistiken verwendet. Rohdaten stehen nur Administratoren zur Verfügung.<br /> 
Es werden keinerlei benutzerspezifische Daten an Dritte weitergegeben. <br /><br />

<h2>Datensicherheit</h2>

Wir  bemühen uns intensiv darum, SIS und Daten unserer Nutzer vor unbefugtem Zugriff zu schützen.<br />
Insbesondere:<br />

<ul>
	<li>
		verschlüsseln wir unseren Dienst unter Nutzung von SSL. 
	</li>
	<li>
		überprüfen wir unsere Praktiken zur Erhebung, Speicherung und Verarbeitung von Daten 
		zum Schutz vor unbefugtem Zugriff auf Systeme. 
	</li>
	<li>
		beschränken wir den Zugriff von Stundenplänen und Supplierplänen  auf die jeweils betroffenen Klassen und Lehrer (Administratoren ausgenommen).
	</li>
	<li>
		beschränken wir den Zugriff auf personenbezogene Daten auf unsere Administratoren.
	</li>	
</ul>

<h2>Änderungen</h2>

Unsere Datenschutzbestimmungen können sich von Zeit zu Zeit ändern. Wir werden die Bestimmungen allerdings nicht ändern, 
ohne dich darüber zu informieren und deine Einwilligung einzuholen. <br />
Alle Änderungen der Datenschutzbestimmungen werden auf dieser Seite veröffentlicht und du wirst darüber informiert. 
Außerdem werden ältere Versionen dieser Datenschutzbestimmungen zu deiner Einsicht in einem Archiv aufbewahrt.<br /><br />

Stand: 18.02.2014 <br /><br />


<hr />
<a name="terms" id="terms"></a>
<a href="#top" onclick="smoothScroll('top'); return false;">Zum Seitenanfang</a>
<h1>Nutzungsbedingungen</h1>


In Arbeit...<br />

<?php
	pageFooter();
?>
