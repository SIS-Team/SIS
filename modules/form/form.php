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


error_reporting(E_ALL);
	 
/*Funktion um die Formulare zu erstellen
 *
 *$field - Array das die Informationen ÃƒÂ¯Ã‚Â¿Ã‚Â½ber das Formular enthÃƒÂ¯Ã‚Â¿Ã‚Â½lt als string 
 *$content- Inhalt des Formulars wenn leeres Formular false sonst array mit Inhalten
 *
 */
 
 
function form_new($field,$content)
{	
$allowedSites = array('substitudes','missingTeacher','missingClasses','news');


printf("<table>\n");	//Tabellen Tag auf
	printf("<tr>\n");	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
  			//FÃƒÂ¯Ã‚Â¿Ã‚Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($field as $f) {	
				
				if($content!=false)	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
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
				else if($f[2] == "dropdown") {												//Dropdown MenÃƒÂ¯Ã‚Â¿Ã‚Â½ erstellen

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"></td>\n",
							$f[1], $f[5], $f[3], $f[0], $f[0]);
							
				}
				
			}
			
			$temp = explode("/", $_SERVER['REQUEST_URI']);
			$temp = $temp[count($temp)-2];

			if($content==false)
			{
				form_savedelete(true);
			}
			else if(array_search($temp,$allowedSites)!==false)
			{
				form_savedelete(false);
			}
			else
			{
				form_savedelete(true);
			}

				
		printf("</form>\n");
  	printf("</tr>\n");
printf("</table>\n");
}

function form_lesson($field,$content)
{	
$zeile=0;
printf("<table>\n");	//Tabellen Tag auf
	do{
				if(($zeile)%5==0){
					$zeile1=1;
					$hour=(($zeile)/5)+1;
					$visibility="style=\"visibility:visible\"";
				}
				else{
					$zeile1=0;
					$hour=floor((($zeile)/5)+1);
					$visibility="style=\"visibility:collapse\"";

				}
				
				$rowID="id=\"visibleRow".($zeile+1-(($hour-1)*5)).$hour."\"";
				$stuff=array('split'=>1,'length'=>1);	
				
				
				if($content!=""){
					unset($index);			
					foreach($content as $i => $c){
						if($c['startHour']==$hour)
						{
							$index=$i;
							$split=$c['same'];
							$length=$c['endHour'] - $c['startHour']+1;
							$room=$c['roName'];
							$subject=$c['suShort'];
							$teacher=$c['teShort'];
							$ID=$c['ID'];
							$startHour = $c['startHour'];
							$stuff=array('ID'=>$c['ID'],'split'=>$split,'length'=>$length,'roName'=>$room,'teShort'=>$teacher,'suShort'=>$subject);
		
							unset($content[$i]);				
						}
						if(isset($index)){
							break;
							}
					}
					if($length>1 && $startHour != $hour && $zeile1==1){
											
						$length--;
						$visibility="style=\"visibility:collapse\"";
					
					}
				}
					
	printf("<tr %s %s>\n",$rowID,$visibility);	//Zeilen 	Tag auf
  		printf("<form method=\"post\">\n");	//Formular Anfang Tag
  			//FÃƒÂ¯Ã‚Â¿Ã‚Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
  			
  			
  			
			foreach($field as $f) {	
				if(isset($index))						//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$stuff[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
					$edit = "readonly";
				}	
				else
					$edit = "";			
				
				
				if($f[2] == "text") {
					printf("<td>%s <input type=\"text\" name=\"%s\" size=\"%spx\" value=\"%s\" %s >\n",	//Textbox erstellen
							$f[1], $f[0], $f[3], $f[5], $f[6]);

				}
				else if($f[2] == "hidden") {
					printf("<td><input type=\"hidden\" name=\"%s\" value=\"%s\">\n",			//Versteckten Typ erstellen
							$f[0], $f[5]);

					if($zeile1==1){
						printf("<td>Teilung: <input type=\"text\" name=\"%s\" id=\"%s\" size=\"2px\" value=\"%s\" onchange=\"javascript:changeText(%s);\" %s>\n",	//Textbox erstellen  			
	  							"visibilityText".$hour,"visibilityText".$hour,$stuff['split'],$hour,$edit);
						printf("<td><input type=\"button\" size=\"4px\" value=\"OK\" onclick=\"javascript:Visibility(%s)\" >\n",	//Textbox erstellen  			
	  							$hour);  						
	  					printf("<td>Stunde: <input type=\"text\" name =\"hour\" size=\"3px\" value=\"%s\" readonly >\n",	//Textbox erstellen  			
	  							$hour);
	  					printf("<td>L&auml;nge: <input type=\"text\" name=\"length\" id=\"%s\" size=\"5px\" value=\"%s\" onchange=\"javascript:visibleHours(%s);\" %s>\n",	//Textbox erstellen
							"visibleHour".$hour, $stuff['length'], $hour,$edit);

	  				}
	  				else{
	  					printf("<td><input type=\"hidden\" name=\"%s\" size=\"2px\" value=\"1\" >\n",	//Textbox erstellen  			
	  							"visibilityText".$hour);
						printf("<td><td>\n");	  						
	  					printf("<td><input type=\"hidden\" name =\"hour\" size=\"3px\" value=\"%s\" readonly >\n",	//Textbox erstellen  			
	  							$hour);

	  				}
	  					printf("<td><input type=\"hidden\" name =\"day\" value=\"%s\" >\n",	//Textbox erstellen  			
	  							$_POST['day']);
						printf("<td><input type=\"hidden\" name =\"class\" value=\"%s\" >\n",	//Textbox erstellen  			
	  							$_POST['class']);
	  											
				}
				else if($f[2] == "dropdown") {												//Dropdown MenÃƒÂ¯Ã‚Â¿Ã‚Â½ erstellen

					printf("<td>%s <input value=\"%s\" autocomplete=\"off\" size=\"%s\" list=\"%s\" name=\"%s\"></td>\n",
							$f[1], $f[5], $f[3], $f[0], $f[0]);
							
				}
				
			}
			if($zeile1==1)
				form_savedelete(false);
			else{
				printf("<td></td>\n");
				form_savedelete(true);
			}
				
		printf("</form>\n");
  	printf("</tr>\n");
  	if(($zeile+1-(($hour-1)*5))==5)
  		printf("<script type=\"text/javascript\">Visibility(%s);</script>",$hour);
  	$zeile+=1;
   	}while($zeile<80);
   	
printf("</table>\n");
}


function form_substitudes($fieldRow1,$fieldRow2,$content)
{	

printf("<table>\n");	//Tabellen Tag auf
	printf("<form method=\"post\">\n");	//Formular Anfang Tag
		printf("<tr>\n");	//Zeilen 	Tag auf
  			//FÃƒÂ¯Ã‚Â¿Ã‚Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
			foreach($fieldRow1 as $f) {	
				
				if($content!=false)	//Wenn Content mitgeliefert wird und der Typ des aktuellen Inputs kein DropDown, dann Content austauschen
				{
					$f[5]=$content[$f[0]];					//Content des aktuellen Inputs austauschen, Name des Array-Indizes ist der name des Inputs
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
				form_savedelete(false);
			}
				
  	printf("</tr>\n");
  	printf("<tr id=\"visibleRow%s\" style=\"visibility:%s\">\n",$ID,$collapse);	//Zeilen 	Tag auf
  			//FÃƒÂ¯Ã‚Â¿Ã‚Â½r jeden Eintrag im Array field einmal diese Schleife durchlaufen
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
 *Erstellt die SchaltflÃƒÂ¯Ã‚Â¿Ã‚Â½chen fÃƒÂ¯Ã‚Â¿Ã‚Â½r Speichern und LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 *$new ist eine Boolsch Variable
 *True bedeutet dass es ein leeres Formular ist --> Kein LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 *False bedeutet kein neues Formular --> LÃƒÂ¯Ã‚Â¿Ã‚Â½schen
 */
function form_savedelete($new)
{

if($new!=true)
	printf("<td>L&ouml;schen<input type=\"checkbox\" name=\"delete\" value=\"delete\"></td>\n");		//Checkbox erstellen

printf("<td><input type=\"submit\" name=\"save\" value=\"Speichern\"></td>\n");	//Submit Button erstellen

}
?>

