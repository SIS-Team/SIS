<?php

include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");

function dateChange($date){


if(isset($_REQUEST['rechts_x']) && $_REQUEST['rechts_x']!="0")	//Wenn nach links gedrückt wird dann Datum increase
{
	$date = date_increase($date);
}

if (isset($_REQUEST['links_x']) && $_REQUEST['links_x']!="0")	//Wenn nach links gedrückt wird dann Datum decrease
{
	$date = date_decrease($date);
}

//Formular ausgeben
printf("<form method=\"post\">");
	printf("<table >");
		printf("<tr style=\"vertical-align:bottom\">");
			printf("<input type=\"image\" name=\"links\" src=\"%s\" align=\"absmiddle\">", RELATIVE_ROOT."/data/images/absentees/Pfeil_l.png");	//Pfeil zurück
			printf( "&nbsp%s <input name=\"date\" value=\"%s\" size=\"10\">  ",weekday($date),$date);			//Textformular ausgeben
 	      	printf("&nbsp<input type=\"image\" name=\"rechts\" src=\"%s\" align=\"absmiddle\">",RELATIVE_ROOT."/data/images/absentees/Pfeil_r.png");	//Pfeil vor
    	printf("</tr>");
	printf("</table>");
printf("</form>");

return $date;
}
?>
