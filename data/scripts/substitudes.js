/* /data/scripts/substitudes.js
 * Autor: Marco Handle
 * Beschreibung:
 *	Scripts für die Substitudes
 *
 */

//Funktion zum ein und ausblenden der neuen Stunden
//id = Zeilennummer
function Visibility(id,typ) {

	if(typ == "free" ){	//Wenn freie Eingabe aktiviert
		if(document.getElementById('visibleCell'+id+"move").style.display=="table-cell"){	//Wenn sichtbar
			document.getElementById('visibleCell'+id+"move").style.display="none";	//unsichtbar
			document.getElementById('visibleCell'+id+"add").style.display="none";	//unsichtbar
			document.getElementById('visibleCell'+id+"remove").style.display="none";//unsichtbar
			document.getElementById('visibleRow'+id).style.display="none";	//unsichtbar
			document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"roName").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"startHour").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//sichtbar
			document.getElementById('visibleSpan'+id).style.display="none";	//unsichtbar
			document.getElementById(id+"comment").value="";	//Kommentar leeren
		 }
		else{		//sonst
			document.getElementById('visibleRadio'+id+"move").checked = true; //Radio Button aktivieren
			document.getElementById('visibleCell'+id+"move").style.display="table-cell"; //sichtbar
			document.getElementById('visibleCell'+id+"add").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"remove").style.display="table-cell";	//sichtbar
			document.getElementById('visibleRow'+id).style.display="table-row"; //sichtbar
			document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell";//sichtbar
			document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell";	//sichtbar
			document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell";	//sichtbar
			document.getElementById('visibleSpan'+id).style.display="none";	//unsichtbar
			document.getElementById(id+"comment").value="Verschiebung von";	//Kommentar füllen
		}
	} 
	else if(typ == "remove" ){ //Wenn Entfall aktiv
		document.getElementById('visibleCell'+id+"suShort").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"teShort").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"roName").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="none";	//unsichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell"; //sichtbar
		document.getElementById('visibleSpan'+id).style.display="table-cell"; //sichtbar machen
		document.getElementById(id+"comment").value="Entfällt";	//Komentar füllen
	}
	else if(typ == "add" ){ //Wenn hinzufügen aktiv
		document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";	//sichtbar
		document.getElementById('visibleSpan'+id).style.display="none";	//unsichtbar
		document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";	//sichtbar
		document.getElementById('visibleCell'+id+"roName").style.display="table-cell";	//sichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//sichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="none"; //unsichtbar
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="none"; //unsichtbar
		document.getElementById(id+"comment").value="";	//Kommentar leeren
	}
	else if(typ == "move" ){ //Wenn Verschiebung aktiv
		document.getElementById('visibleCell'+id+"suShort").style.display="table-cell";	//sichtbar
		document.getElementById('visibleCell'+id+"teShort").style.display="table-cell";	//sichtbar
		document.getElementById('visibleSpan'+id).style.display="none";	//sichtbar
		document.getElementById('visibleCell'+id+"roName").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"startHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"endHour").style.display="table-cell";	//sichtbar
		document.getElementById('visibleCell'+id+"oldStartHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"oldEndHour").style.display="table-cell"; //sichtbar
		document.getElementById('visibleCell'+id+"oldTeShort").style.display="table-cell"; //sichtbar
		document.getElementById(id+"comment").value="Verschiebung von";	//Kommentar füllen
	}
}
