/* /data/scripts/substitudes.js
 * Autor: Marco Handle
 * Beschreibung:
 *	Scripts für die Substitudes
 *
 */

//Funktion zum ein und ausblenden der neuen Stunden
//id = Zeilennummer
function Visibility(id,typ) {

	if(typ == "free" ){
		if(document.getElementById('visibleCell'+id+"move").style.display=="table-cell"){	//Wenn die Zeile sichtbar
			document.getElementById('visibleCell'+id+"move").style.display="none";		//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"add").style.display="none";		//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"remove").style.display="none";	//Zeile unsichtbar
			document.getElementById('visibleRow'+id).style.display="none";			//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";		//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";		//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"roName").style.display="table-cell";	//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"startHour").style.display="table-cell";		//Zeile unsichtbar
			document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//Zeile unsichtbar
			document.getElementById('visibleSpan'+id).style.display="none";	//sichtbar machen
			document.getElementById(id+"comment").value="";	//sichtbar machen
		 }
		else{		//sonst
			document.getElementById('visibleRadio'+id+"move").checked = true;
			document.getElementById('visibleCell'+id+"move").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleCell'+id+"add").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleCell'+id+"remove").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleRow'+id).style.display="table-row";
			document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell";	//sichtbar machen
			document.getElementById('visibleSpan'+id).style.display="none";	//sichtbar machen
			document.getElementById(id+"comment").value="Verschiebung von";	//sichtbar machen
		}
	}
	else if(typ == "remove" ){
		document.getElementById('visibleCell'+id+"suShort").style.display="none";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"teShort").style.display="none";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"roName").style.display="none";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="none";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="none";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell";	//sichtbar machen
		document.getElementById('visibleSpan'+id).style.display="table-cell";	//sichtbar machen
		document.getElementById(id+"comment").value="Entfällt";	//sichtbar machen
	}
	else if(typ == "add" ){
		document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleSpan'+id).style.display="none";	//sichtbar machen
		document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"roName").style.display="table-cell";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="none";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="none";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="none";	//sichtbar machen
		document.getElementById(id+"comment").value="";	//sichtbar machen
	}
	else if(typ == "move" ){
		document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleSpan'+id).style.display="none";	//sichtbar machen
		document.getElementById('visibleCell'+id+"roName").style.display="table-cell";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="table-cell";		//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//Zeile unsichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell";	//sichtbar machen
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell";	//sichtbar machen
		document.getElementById(id+"comment").value="Verschiebung von";	//sichtbar machen
	}
}

function failAlert(){ 
	alert("Es konnte keine Stunde für\ndiese Supplierung gefunden werden.\nBitte tragen sie diesen Lehrer\nals fehlend ein, oder\nkorrigieren sie die Eingabe.");
}
