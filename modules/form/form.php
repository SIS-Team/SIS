<?php
	/* /modules/form/form.php
	 * Autor: Handle Marco
	 * Version: 0.4.0
	 * Beschreibung:
	 *	Funktionen fÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¼r Formulare
	 *
	 * Changelog:
	 * 	0.1.0:  23. 06. 2013, Handle Marco - erste Version
	 *	0.2.0	24. 06. 2013, Handle Marco - Erweiterung Formular erstellen
	 *	0.3.0	28. 06. 2013, Handle Marco - Funktion fÃƒÂ¯Ã‚Â¿Ã‚Â½r Speicher und LÃƒÂ¯Ã‚Â¿Ã‚Â½sch-Button
	 *	0.4.0	22. 07. 2013, Handle Marco - Ersetzen des Dropdown-Menues mit datalist(HTML5)
	 */
/*
//Bei einem Dropdown-MenÃƒÂ¯Ã‚Â¿Ã‚Â½ werden die Auswahltexte wie folgt angegeben:
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
	array( "datum", 	"Datum: ", 		"textarea", "10",	"10",	"haÃƒÂ¯Ã‚Â¿Ã‚Â½ÃƒÂ¯Ã‚Â¿Ã‚Â½p",	""),
	array( "klasse", 	"Klasse: ", 	"checkbox", "",		"",		"checked",	""),
	array( "lehrer", 	"Lehrer: ", 	"checkbox", "",		"",		"",			""),
	array( "fach", 		"Fach: ", 		"button", 	"",		"",		"",			""),
	array( "check", 	"Ok", 			"dropdown",	"",		"",		$select,	""),		
	);

*/


//error_reporting(E_ALL);
	 
/*Funktion um die Formulare zu erstellen
 *
 *$field - Array das die Informationen ÃƒÂ¯Ã‚Â¿Ã‚Â½ber das Formular enthÃƒÂ¯Ã‚Â¿Ã‚Â½lt als string 
 *$content- Inhalt des Formulars wenn leeres Formular false sonst array mit Inhalten
 *
 */
 
 
function form_new($field,$content)
{	


printf("<table>\n");	//Tabellen Tag auf
	printf("<tr>\n");	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
  			//FÃƒÂ¯Ã‚Â¿Ã‚Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($field as $f) {	
				
				if($content!=false)	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs					
				}
				else if($f[2] == "text") {
					printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
							$f[1], $f[0], $f[3], $f[5], $f[6]);

				}
				else if($f[2] == "button") {
					printf("<td><input type=\"submit\" name=\"%s\" value=\"%s\" style=\"width: %spx; height: %spx\" %s>\n",	//Button erstellen
							$f[0], $f[1], $f[3], $f[4], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[5]);

				}
				else if($f[2] == "dropdown") {												//Dropdown MenÃƒÂ¯Ã‚Â¿Ã‚Â½ erstellen

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"></td>\n",
							$f[1], $f[5], $f[3], $f[0], $f[0]);
							
				}
				
			}
			
			if($content==false)
			{
				form_savedelete(true);
			}
			else
			{
				form_savedelete(true);
			}

				
		printf("</form>\n");
  	printf("</tr>\n");
printf("</table>\n");
}


/*
 *Erstellt die SchaltflÃƒÂ¯Ã‚Â¿Ã‚Â½chen fÃƒÂ¯Ã‚Â¿Ã‚Â½r Speichern und LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 *$new ist eine Boolsch Variable
 *True bedeutet dass es ein leeres Formular ist --> Kein LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 *False bedeutet kein neues Formular --> LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 */
function form_savedelete($new)
{

if($new!=true)
	printf("<td>L&ouml;schen<input type=\"checkbox\" name=\"delete\" value=\"delete\"></td>\n");		//Checkbox erstellen

printf("<td><input type=\"submit\" name=\"save\" value=\"&Uuml;bernehmen\"></td>\n");	//Submit Button erstellen

}
?>

