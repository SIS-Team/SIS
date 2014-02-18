<?php
	include("../../config.php");
	//die nächste datei würde dei db connect ersetzen
	include(ROOT_LOCATION . "/modules/general/Connect.php");
	include(ROOT_LOCATION . "/modules/general/SessionManager.php");	

	header('Content-Type: application/javascript; charset=UTF-8');	
	


	$today = date("Y-m-d");
			$sql = "SELECT * FROM `news` WHERE `startDay` <= '" . $today . "' AND `endDay` >= '" . $today . "' AND `display` = 1";
			$result = mysql_query($sql);
			//$response['content'] .= "<table class=\"news\">";
			while ($row = mysql_fetch_object($result)) {
				$response[]=$row;
				/*$response['content'] .= "<tr><th>" . $row->title . "</th></tr>";
				$response['content'] .= "<tr><td>" . $row->text  . "</td></tr>";
				*/
			}

	echo "var response =".$response."\n";
	$response = json_encode($response);
	$response = str_replace('\n',' ', $response);
	$response = str_replace('\r','', $response);
	echo "var newsObject = JSON.parse('" . $response . "');\n";

?>


$( document ).ready(function() {
	
	var i;

	for(aNews in newsObject){
				
		var news = newsObject[aNews];
	

		var newTitle = document.createElement("h2");
		newTitle.id = "title" + i;
		document.getElementById("main").appendChild(newTitle);
		var newText = document.createElement("div");
		newText.id = "text" + i;
		document.getElementById("main").appendChild(newText);

		document.getElementById("title" + i).innerHTML=news.title;
		document.getElementById("text" + i).innerHTML=news.text;

		i++;
	}
		
				
});