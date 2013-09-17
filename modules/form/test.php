<script type="text/javascript">
function Visibility() {
	
var temp = parseInt(document.getElementById('inputText').value);	

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
}

var i=2;

document.getElementById('visibleRow2').style.visibility="collapse";
document.getElementById('visibleRow3').style.visibility="collapse";
document.getElementById('visibleRow4').style.visibility="collapse";
document.getElementById('visibleRow5').style.visibility="collapse";


do{

document.getElementById('visibleRow'+i).style.visibility="visible";

i++;
}while(i<=zahl);
	

}


function test(){

var texts;
text=document.getElementById('test1').value;

document.getElementById('test2').value=text;
document.getElementById('test3').value=text;


}
</script>

<html>

<body>

<?php
function prevNextDay($d) {
	$days = array("Mo", "Di", "Mi", "Do", "Fr");
	$arr=array_keys($days,$d);
	
	$key=implode($arr);
	
	if($key>0 && $key<4){
		$prev=$days[$key-1];
		$next=$days[$key+1];
	}
	else if($key==0){
		$prev="";
		$next=$days[$key+1];
	}
	else if($key==4){
		$next="";
		$prev=$days[$key-1];
	}

	$array['prev']=$prev;
	$array['next']=$next;
	
	return $array;

prevNextDay("Fr");

$_POST['Class']="1A";
print_r($_POST);
?>


</body>
</html>

