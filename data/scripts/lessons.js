/* /data/scripts/lessons.js
 * Autor: Marco Handle
 * Beschreibung:
 *	Scripts für die Lessons
 *
 */

function Visibility(hour) {
	
var temp = parseInt(document.getElementById('visibilityText'+hour).value);	

switch(temp){
	case 2: 
		var zahl = 2; 
		break;
	case 3: 
		var zahl = 3;
		break; 
	case 4: 
		var zahl = 4; 
		break;
	case 5: 
		var zahl = 5; 
		break;
	case 6: 
		var zahl = 6; 
		break;
	case 7: 
		var zahl = 7; 
		break;

	default: 
		var zahl = 1;
		break;
}

var i=2;

document.getElementById('visibleRow2'+hour).style.visibility="collapse";
document.getElementById('visibleRow3'+hour).style.visibility="collapse";
document.getElementById('visibleRow4'+hour).style.visibility="collapse";
document.getElementById('visibleRow5'+hour).style.visibility="collapse";
document.getElementById('visibleRow6'+hour).style.visibility="collapse";
document.getElementById('visibleRow7'+hour).style.visibility="collapse";


while(i<=zahl){

document.getElementById('visibleRow'+i+hour).style.visibility="visible";

i++;
}

}

function text(text,hour){

document.getElementById('visibilityText'+hour).value = text;

document.getElementsByName('visibilityText'+hour)[1].value=text;
document.getElementsByName('visibilityText'+hour)[2].value=text;
document.getElementsByName('visibilityText'+hour)[3].value=text;
document.getElementsByName('visibilityText'+hour)[4].value=text;
document.getElementsByName('visibilityText'+hour)[5].value=text;
document.getElementsByName('visibilityText'+hour)[6].value=text;

}

function changeText(hour){

var text;
text=document.getElementById('visibilityText'+hour).value;

document.getElementsByName('visibilityText'+hour)[1].value=text;
document.getElementsByName('visibilityText'+hour)[2].value=text;
document.getElementsByName('visibilityText'+hour)[3].value=text;
document.getElementsByName('visibilityText'+hour)[4].value=text;
document.getElementsByName('visibilityText'+hour)[5].value=text;
document.getElementsByName('visibilityText'+hour)[6].value=text;

}

function visibleHours(hour){


var length=parseInt(document.getElementById('visibleHour'+hour).value);
var endHour = hour + length -1;
var ii = hour+1;

while(ii<=16){

if(parseInt(document.getElementById('visibleHour'+ii).value)==1){
	document.getElementById('visibleRow1'+ii).style.visibility="visible";
	ii+=1;
}
else
	ii+=parseInt(document.getElementById('visibleHour'+ii).value);

}

ii=hour+1;

while(ii<=endHour){

document.getElementById('visibleRow1'+ii).style.visibility="collapse";
document.getElementById('visibleRow2'+ii).style.visibility="collapse";
document.getElementById('visibleRow3'+ii).style.visibility="collapse";
document.getElementById('visibleRow4'+ii).style.visibility="collapse";
document.getElementById('visibleRow5'+ii).style.visibility="collapse";
document.getElementById('visibleRow6'+ii).style.visibility="collapse";
document.getElementById('visibleRow7'+ii).style.visibility="collapse";

ii+=1;

}

}
