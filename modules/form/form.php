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
 *$field - Array das die Informationen �ber das Formular enth�lt als string 
 *$content- Inhalt des Formulars wenn leeres Formular false sonst array mit Inhalten
 *
 */
function form_new($field,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<tr>\n");	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
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
							break;
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
					printf("<td><input type=\"submit\" name=\"%s\" value=\"%s\" style=\"width: %spx; height: %spx\" %s>\n",	//Button erstellen
							$f[0], $f[1], $f[3], $f[4], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[5]);

				}
				else if($f[2] == "dropdown") {												//Dropdown Men� erstellen
					$select="";
					
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

function form_substitudes($fieldRow1,$fieldRow2,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<form method=\"post\">\n");	//Formular Anfang Tag
		printf("<tr>\n");	//Zeilen 	Tag auf
  			//F�r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($fieldRow1 as $f) {	
				
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
							break;
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
				else if ($f[2] == "checkboxJava") {		//Checkbox
					$collapse="collapse";
					if($f[5]=="1"){			//Wenn gecheckt, dann Variable checked auf checked setzen
						$checked="checked";
						$collapse="visible";				
					}
					else{						//sonst leer
						$checked="";
						$collapse="collapse";
					}
					if(empty($content["ID"]))
						$ID=0;
					else
						$ID=$content["ID"];
						
					printf("<td>%s <input type=\"checkbox\" name=\"%s\" %s value=\"%s\" onclick=\"javascript:Visibility(%s)\">\n",		//Checkbox erstellen
							$f[1], $f[0], $checked, $f[0],$ID);
					
				}
				else if($f[2] == "text") {
					printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
							$f[1], $f[0], $f[3], $f[5], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[5]);

				}
				else if($f[2] == "dropdown") {												//Dropdown Men� erstellen
					$select="";
					
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
				
  	printf("</tr>\n");
  	printf("<tr id=\"visibleRow%s\" style=\"visibility:%s\">\n",$ID,$collapse);	//Zeilen 	Tag auf
  			//F�r jeden Eintrag im Array field einmal diese Schleife durchlaufen
  			printf("<td colspan=\"7\"></td>\n");
			foreach($fieldRow2 as $f) {	
					
				if($content!=false)	//Wenn Content mitgeliefert, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
				}

				printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
						$f[1], $f[0], $f[3], $f[5], $f[6]);	
								
			}
			
  	printf("</tr>\n");
	printf("</form>\n");
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
?>

