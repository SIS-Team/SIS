<?php
	/* /modules/form/form.php
	 * Autor: Handle Marco
	 * Version: 0.4.0
	 * Beschreibung:
	 *	Funktionen fÃ¼r Formulare
	 *
	 * Changelog:
	 * 	0.1.0:  23. 06. 2013, Handle Marco - erste Version
	 *	0.2.0	24. 06. 2013, Handle Marco - Erweiterung Formular erstellen
	 *	0.3.0	28. 06. 2013, Handle Marco - Funktion f�r Speicher und L�sch-Button
	 *	0.4.0	22. 07. 2013, Handle Marco - Ersetzen des Dropdown-Menues mit datalist(HTML5)
	 */
/*
//Bei einem Dropdown-Men� werden die Auswahltexte wie folgt angegeben:
			value		name		select(true||"")
$select = array(
	array( "test1", 	"Test1", 	"true"),
	array( "test2", 	"Test2", 	""),
	array( "test3", 	"Test3", 	""),
	);

//Das Formular wird wie folgt beschrieben:
			name		Text			Typ			size_a	size_b	value		sonstiges	
$fields = array(
	array( "std", 		"Stunde(n): ", 	"text", 	"15",	"",		"test",		"readonly=\"true\""),
	array( "datum", 	"Datum: ", 		"textarea", "10",	"10",	"ha��p",	""),
	array( "klasse", 	"Klasse: ", 	"checkbox", "",		"",		"checked",	""),
	array( "lehrer", 	"Lehrer: ", 	"checkbox", "",		"",		"",			""),
	array( "fach", 		"Fach: ", 		"button", 	"",		"",		"",			""),
	array( "check", 	"Ok", 			"dropdown",	"",		"",		$select,	""),		
	);

*/


error_reporting(E_ALL);
	 
/*Funktion um die Formulare zu erstellen
 *
 *$method- Methode(get,post) als string
 *$action- Action als string
 *$field - Array das die Informationen �ber das Formular enth�lt als string 
 *$content- Inhalt des Formulars wenn leeres Formular false sonst array mit Inhalten
 *
 */
function form_new($method,$action,$field,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<tr>\n");	//Zeilen 	Tag auf
  		printf("<form method=\"%s\" action=\"%s\">\n",$method,$action);	//Formular Anfang Tag
  			//F�r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($field as $f) {	
				
				if($content!=false && $f[2]!="dropdown")	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
				}
				else if($content!=false && $f[2]=="dropdown")	//Wenn Content mitgeliefert wird und der Typ des des aktuellen Inputs ein DropDown ist, dann Sonderbehandlung
				{
					foreach($f[5] as $ii => $a)				//F�r jeden Inhalt(Eintr�g der DropDown Liste) wird �berpr�ft ob der content mit dem Einrag in der DropDown Liste �bereinstimmt --> ausgew�hlt
					{
						if($a[0]==$content[$f[0]])			//Wenn ein Eintrag mit dem mitgegebenen Eintrag �bereinstimmt, dann in dem Aktuellen Input, beim Inhalt und dem Entsprechenden Eintrag select auf true setzen
						{	
							$f[5][$ii][1]=true;
						}
						else								//sonst leer
						{
							$f[5][$ii][1]="";
						}
					}
				}
	
				if ($f[2] == "checkbox") {		//Checkbox
				
					if($f[5]==true){			//Wenn gecheckt, dann Variable checked auf checked setzen
						$checked="checked";
					}
					else{						//sonst leer
						$checked="";					
					}
					
					printf("<td>%s <input type=\"checkbox\" name=\"%s\" %s value=\"%s\" %s>\n",		//Checkbox erstellen
							$f[1], $f[0], $checked, $f[0],$f[6]);
					
				}
				else if($f[2] == "text") {
					printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
							$f[1], $f[0], $f[3], $f[5], $f[6]);

				}
				else if($f[2] == "textarea") {
					printf("<td>%s <textarea name=\"%s\" cols=\"%s\" rows=\"%s\" %s>%s</textarea>\n",	//Textarea erstellen
							$f[1], $f[0], $f[3], $f[4], $f[6], $f[5]);

				}
				else if($f[2] == "button") {
					printf("<td><input type=\"button\" name=\"%s\" value=\"%s\" style=\"width: %spx; height: %spx\" %s>\n",	//Button erstellen
							$f[0], $f[1], $f[3], $f[4], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[1]);

				}
				else if($f[2] == "dropdown") {												//Dropdown Men� erstellen
				
					foreach($f[5] as $p)													//F r jeden Men eintrag im Array f einen Eintrag erstellen
						{
							if($p[1]==true){													//wenn ausgew hlt selected
								$select=$p[0];
							}
						}

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"><datalist id=\"%s\"  %s>\n",
							$f[1], $select, $f[3], $f[0], $f[0], $f[0], $f[6]);
							
					foreach($f[5] as $p)													//F�r jeden Men�eintrag im Array f einen Eintrag erstellen
					{
							printf("<option value=\"%s\">\n", $p[0]);
					}

					printf("</datalist></td>\n");
				}
				
			}
			
			if($content==false)
			{
				form_savedelete(true);
			}
			else
			{
				form_savedelete(false);
			}
				
		printf("</form>\n");
  	printf("</tr>\n");
printf("</table>\n");
}
	 

/*
 *Erstellt die Schaltfl�chen f�r Speichern und L�schen
 *$new ist eine Boolsch Variable
 *True bedeutet dass es ein leeres Formular ist --> Kein L�schen
 *False bedeutet kein neues Formular --> L�schen
 */
function form_savedelete($new)
{

if($new!=true)
	printf("<td>L&ouml;schen<input type=\"checkbox\" name=\"delete\" value=\"delete\"></td>\n");		//Checkbox erstellen

printf("<td><input type=\"submit\" name=\"save\" value=\"Speichern\"></td>\n");	//Submit Button erstellen

}

/*
function save()
{
	$arr = explode(',', $_POST["std"]);			//Stunden aufspalten bei Beistrich und in Array speichern
		
		foreach($arr as $stunde){					//für jeden Stundeneintrag wird deis einml abgearbeitet
			$fls = array();							//leeres Array erstellen für die Namen der Spalten
			$vals = array();						//leeres Array erstellen für die Spaltenwerte
			
			foreach ($fields as $f) {				//für jedes Feld im Formular die Werte und deren Name in die zuvor erstellten Werte schreieben
				array_push($fls, $f[0]);
				array_push($vals, $_POST[$f[0]]);
			}
			$vals[1] = $stunde;						//Stunde "ausbessern"
			$fl = implode(",", $fls);				//Beistriche nach jedem Wert einfügen
			$val = implode("','", $vals);			//Beistriche und Hochkommas einfügen
			mysql_query("INSERT INTO Supplierungen ($fl) VALUES('$val')");		//In MYSQL Tabelle speichern



}
*/
/*

 if (!empty($_POST["save"])) {		//wenn save rückgabe nicht leer
	if (empty($_POST["ID"])) {		//wenn keine ID --> neuer Eintrag sonst Update
		$arr = explode(',', $_POST["std"]);			//Stunden aufspalten bei Beistrich und in Array speichern
		
		foreach($arr as $stunde){					//für jeden Stundeneintrag wird deis einml abgearbeitet
			$fls = array();							//leeres Array erstellen für die Namen der Spalten
			$vals = array();						//leeres Array erstellen für die Spaltenwerte
			
			foreach ($fields as $f) {				//für jedes Feld im Formular die Werte und deren Name in die zuvor erstellten Werte schreieben
				array_push($fls, $f[0]);
				array_push($vals, $_POST[$f[0]]);
			}
			$vals[1] = $stunde;						//Stunde "ausbessern"
			$fl = implode(",", $fls);				//Beistriche nach jedem Wert einfügen
			$val = implode("','", $vals);			//Beistriche und Hochkommas einfügen
			mysql_query("INSERT INTO Supplierungen ($fl) VALUES('$val')");		//In MYSQL Tabelle speichern
		}
	}		
	else {
		$vals = array();	//leeres Array erstellen für die Werte
		foreach ($fields as $f) {				//für jedes Feld im Formular die Werte und deren Name in die zuvor erstellten Werte schreieben
			array_push($vals, $f[0]."='".$_POST[$f[0]]."'");
		}
		$val = implode(",", $vals);	//Beistriche nach jedem Wert einfügen
		mysql_query("UPDATE Supplierungen SET $val WHERE ID=".$_POST["ID"]);		//MYSQL Tabelle updaten
	}
}
else if (!empty($_POST["delete"]) & $_POST["Wirklich"]=="loeschen")	//Wenn löschen und hacken gesetzt EIntrag mit zugehöriger ID löschen
{
	if ($_POST["ID"]) {
		mysql_query("DELETE FROM Supplierungen WHERE ID=".$_POST["ID"]);			
	}

}
*/
	 
	 
?>