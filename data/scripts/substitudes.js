/* /data/scripts/substitudes.js
 * Autor: Marco Handle
 * Beschreibung:
 *	Scripts für die Substitudes
 *
 */

//Funktion zum ein und ausblenden der neuen Stunden
//id = Zeilennummer
function Visibility(id) {

	if(document.getElementById('visibleRow'+id).style.visibility=="visible")	//Wenn die Zeile sichtbar
		document.getElementById('visibleRow'+id).style.visibility="collapse";	//Zeile unsichtbar
	else																		//sonst
		document.getElementById('visibleRow'+id).style.visibility="visible";	//sichtbar machen
}

function failAlert(){ 
	alert("Es konnte keine Stunde für\ndiese Supplierung gefunden werden.\nBitte tragen sie diesen Lehrer\nals fehlend ein, oder\nkorrigieren sie die Eingabe.");
}
