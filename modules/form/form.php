<?php
	/* /modules/form/form.php
	 * Autor: Handle Marco
	 * Version: 0.4.0
	 * Beschreibung:
	 *	Funktionen fÃƒÆ’Ã‚Â¼r Formulare
	 *
	 * Changelog:
	 * 	0.1.0:  23. 06. 2013, Handle Marco - erste Version
	 *	0.2.0	24. 06. 2013, Handle Marco - Erweiterung Formular erstellen
	 *	0.3.0	28. 06. 2013, Handle Marco - Funktion fÃ¯Â¿Â½r Speicher und LÃ¯Â¿Â½sch-Button
	 *	0.4.0	22. 07. 2013, Handle Marco - Ersetzen des Dropdown-Menues mit datalist(HTML5)
	 */
/*
//Bei einem Dropdown-MenÃ¯Â¿Â½ werden die Auswahltexte wie folgt angegeben:
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
	array( "datum", 	"Datum: ", 		"textarea", "10",	"10",	"haÃ¯Â¿Â½Ã¯Â¿Â½p",	""),
	array( "klasse", 	"Klasse: ", 	"checkbox", "",		"",		"checked",	""),
	array( "lehrer", 	"Lehrer: ", 	"checkbox", "",		"",		"",			""),
	array( "fach", 		"Fach: ", 		"button", 	"",		"",		"",			""),
	array( "check", 	"Ok", 			"dropdown",	"",		"",		$select,	""),		
	);

*/


error_reporting(E_ALL);
	 
/*Funktion um die Formulare zu erstellen
 *
 *$field - Array das die Informationen Ã¯Â¿Â½ber das Formular enthÃ¯Â¿Â½lt als string 
 *$content- Inhalt des Formulars wenn leeres Formular false sonst array mit Inhalten
 *
 */
function form_new($field,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<tr>\n");	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
  			//FÃ¯Â¿Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($field as $f) {	
				
				if($content!=false && $f[2]!="dropdown")	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
				}
				else if($content!=false && $f[2]=="dropdown")	//Wenn Content mitgeliefert wird und der Typ des des aktuellen Inputs ein DropDown ist, dann Sonderbehandlung
				{
					foreach($f[5] as $ii => $a)				//FÃ¯Â¿Â½r jeden Inhalt(EintrÃ¯Â¿Â½g der DropDown Liste) wird Ã¯Â¿Â½berprÃ¯Â¿Â½ft ob der content mit dem Einrag in der DropDown Liste Ã¯Â¿Â½bereinstimmt --> ausgewÃ¯Â¿Â½hlt
					{
						if($a[0]==$content[$f[0]])			//Wenn ein Eintrag mit dem mitgegebenen Eintrag Ã¯Â¿Â½bereinstimmt, dann in dem Aktuellen Input, beim Inhalt und dem Entsprechenden Eintrag select auf true setzen
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
				else if($f[2] == "dropdown") {												//Dropdown MenÃ¯Â¿Â½ erstellen
					$select="";
					
					foreach($f[5] as $p)													//F r jeden Men eintrag im Array f einen Eintrag erstellen
						{
							if($p[1]==true){													//wenn ausgew hlt selected
								$select=$p[0];
							}
						}

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"><datalist id=\"%s\"  %s>\n",
							$f[1], $select, $f[3], $f[0], $f[0], $f[0], $f[6]);
							
					foreach($f[5] as $p)													//FÃ¯Â¿Â½r jeden MenÃ¯Â¿Â½eintrag im Array f einen Eintrag erstellen
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

function form_lesson($field,$content)
{	
$zeile=1;
printf("<table>\n");	//Tabellen Tag auf
	do{
				if(($zeile-1)%5==0){
					$zeile1=1;
					$visibility="";
					$hour=(($zeile-1)/5)+1;
					$rowID="";
				}
				else{
					$zeile1=0;
					$visibility="style=\"visibility:collapse\"";
					$hour=floor((($zeile-1)/5)+1);
					$rowID="id=\"visibleRow".($zeile-(($hour-1)*5)).$hour."\"";
				}
					
					
	printf("<tr %s %s>\n",$rowID,$visibility);	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
  			//FÃ¯Â¿Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
  			
  			
  			
			foreach($field as $f) {	
				
				if($content!=false && $f[2]!="dropdown")	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
				}
				else if($content!=false && $f[2]=="dropdown")	//Wenn Content mitgeliefert wird und der Typ des des aktuellen Inputs ein DropDown ist, dann Sonderbehandlung
				{
					foreach($f[5] as $ii => $a)				//FÃ¯Â¿Â½r jeden Inhalt(EintrÃ¯Â¿Â½g der DropDown Liste) wird Ã¯Â¿Â½berprÃ¯Â¿Â½ft ob der content mit dem Einrag in der DropDown Liste Ã¯Â¿Â½bereinstimmt --> ausgewÃ¯Â¿Â½hlt
					{
						if($a[0]==$content[$f[0]])			//Wenn ein Eintrag mit dem mitgegebenen Eintrag Ã¯Â¿Â½bereinstimmt, dann in dem Aktuellen Input, beim Inhalt und dem Entsprechenden Eintrag select auf true setzen
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
				
				
				
				if($f[2] == "text") {
					printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
							$f[1], $f[0], $f[3], $f[5], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[5]);

					if($zeile1==1){
						printf("<td>Teilung: <input type=\"text\" name=\"%s\" id=\"%s\" size=\"2px\" value=\"1\" onchange=\"javascript:changeText(%s);\">\n",	//Textbox erstellen  			
	  							"visibilityText".$hour,"visibilityText".$hour,$hour);
						printf("<td><input type=\"button\" size=\"4px\" value=\"OK\" onclick=\"javascript:Visibility(%s)\" >\n",	//Textbox erstellen  			
	  							$hour);	  						
	  					printf("<td>Stunde: <input type=\"text\" name =\"hour\" size=\"3px\" value=\"%s\" readonly >\n",	//Textbox erstellen  			
	  							$hour);

	  				}
	  				else{
	  					printf("<td><input type=\"hidden\" name=\"%s\" size=\"2px\" value=\"1\" >\n",	//Textbox erstellen  			
	  							"visibilityText".$hour);
						printf("<td>\n",	//Textbox erstellen  			
	  							$hour);	  						
	  					printf("<td><input type=\"hidden\" name =\"hour\" size=\"3px\" value=\"%s\" readonly >\n",	//Textbox erstellen  			
	  							$hour);

	  				}

					
				}
				else if($f[2] == "dropdown") {												//Dropdown MenÃ¯Â¿Â½ erstellen
					$select="";
					
					foreach($f[5] as $p)													//F r jeden Men eintrag im Array f einen Eintrag erstellen
						{
							if($p[1]==true){													//wenn ausgew hlt selected
								$select=$p[0];
							}
						}

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"><datalist id=\"%s\"  %s>\n",
							$f[1], $select, $f[3], $f[0], $f[0], $f[0], $f[6]);
							
					foreach($f[5] as $p)													//FÃ¯Â¿Â½r jeden MenÃ¯Â¿Â½eintrag im Array f einen Eintrag erstellen
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
  	$zeile+=1;
   	}while($zeile<=80);
printf("</table>\n");
}


function form_substitudes($fieldRow1,$fieldRow2,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<form method=\"post\">\n");	//Formular Anfang Tag
		printf("<tr>\n");	//Zeilen 	Tag auf
  			//FÃ¯Â¿Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($fieldRow1 as $f) {	
				
				if($content!=false && $f[2]!="dropdown")	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
				}
				else if($content!=false && $f[2]=="dropdown")	//Wenn Content mitgeliefert wird und der Typ des des aktuellen Inputs ein DropDown ist, dann Sonderbehandlung
				{
					foreach($f[5] as $ii => $a)				//FÃ¯Â¿Â½r jeden Inhalt(EintrÃ¯Â¿Â½g der DropDown Liste) wird Ã¯Â¿Â½berprÃ¯Â¿Â½ft ob der content mit dem Einrag in der DropDown Liste Ã¯Â¿Â½bereinstimmt --> ausgewÃ¯Â¿Â½hlt
					{
						if($a[0]==$content[$f[0]])			//Wenn ein Eintrag mit dem mitgegebenen Eintrag Ã¯Â¿Â½bereinstimmt, dann in dem Aktuellen Input, beim Inhalt und dem Entsprechenden Eintrag select auf true setzen
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
				else if($f[2] == "dropdown") {												//Dropdown MenÃ¯Â¿Â½ erstellen
					$select="";
					
					foreach($f[5] as $p)													//F r jeden Men eintrag im Array f einen Eintrag erstellen
						{
							if($p[1]==true){													//wenn ausgew hlt selected
								$select=$p[0];
							}
						}

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"><datalist id=\"%s\"  %s>\n",
							$f[1], $select, $f[3], $f[0], $f[0], $f[0], $f[6]);
							
					foreach($f[5] as $p)													//FÃ¯Â¿Â½r jeden MenÃ¯Â¿Â½eintrag im Array f einen Eintrag erstellen
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
  			//FÃ¯Â¿Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
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
 *Erstellt die SchaltflÃ¯Â¿Â½chen fÃ¯Â¿Â½r Speichern und LÃ¯Â¿Â½schen
 *$new ist eine Boolsch Variable
 *True bedeutet dass es ein leeres Formular ist --> Kein LÃ¯Â¿Â½schen
 *False bedeutet kein neues Formular --> LÃ¯Â¿Â½schen
 */
function form_savedelete($new)
{

if($new!=true)
	printf("<td>L&ouml;schen<input type=\"checkbox\" name=\"delete\" value=\"delete\"></td>\n");		//Checkbox erstellen

printf("<td><input type=\"submit\" name=\"save\" value=\"Speichern\"></td>\n");	//Submit Button erstellen

}
?>

