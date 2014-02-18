<?php

function ifNotLoggedInGotoLogin(){
	if(!($_SESSION['loggedIn'])){
		header("LOCATION: " . RELATIVE_ROOT . "/login/?return=" . urlencode($_SERVER['REQUEST_URI']));
		exit();
	}
}

function getPermission(){
	if(($_SESSION['rights']['root'])){
 			return "root";
	}
	else{
		$isAdmin = $_SESSION['rights']['E'] || $_SESSION['rights']['N'] || $_SESSION['rights']['W'] || $_SESSION['rights']['M'];
		if($isAdmin){
			return "admin";
		} 
		else{
			if($_SESSION['rights']['news']){
				return "news";
			}
			else return false;	
			
		}
 	}
 }
function noPermission(){
 		header("Location: ".RELATIVE_ROOT."/");
		exit();
 }
?>