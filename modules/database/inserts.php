<?php

	/* /modules/database/inserts.php
	 * Autor: Handle Marco
	 * Version: 0.1.0
	 * Beschreibung:
	 *	Select Befehle fÃ¼r die Datenbank
	 *
	 * Changelog:
	 * 	0.1.0:  27. 07. 2013, Handle Marco - erste Version
	 */


function classes(){

$post=$_POST;
print_r($post);
unset($post["save"]);

$classesInsert=array("ID" => "","name" => "","sectionFK" => "","teacherFK" => "","roomFK" => "");

$classesInsert["ID"]=$post["ID"];
$classesInsert["name"]=$post["clName"];

$temp = mysql_fetch_array(mysql_query("SELECT ID FROM sections WHERE short='".$post["seShort"]."'"));
$classesInsert["sectionFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM teachers WHERE short='".$post["teShort"]."'"));
$classesInsert["teacherFK"] = $temp["ID"];
$temp = mysql_fetch_array(mysql_query("SELECT ID FROM rooms WHERE name='".$post["roName"]."'"));
$classesInsert["roomFK"] = $temp["ID"];

if(empty($post["delete"]))
	saveupdate($classesInsert,"classes");
else
	delete($classesInsert["ID"],"classes");
}


function saveUpdate($insert,$table){

	if(empty($insert['ID']))
	{
	
		$col="";
		$dat="";
		$len=count($insert);
		$lauf=1;

		foreach($insert as $i => $p)
		{
			if($i != "ID"){
				$col.= $i;
				$dat.= "'".$p."'";
				if($lauf < $len){
					$col.=" , ";
					$dat.=" , ";
				}
			}
			$lauf+=1;		
		}

		$sql="INSERT INTO ".$table." (".$col.") VALUES (".$dat.")";
	
	}
	else if(!empty($insert['ID']))
	{
		$dat="";
		$len=count($insert);
		$lauf=1;
		
		foreach($insert as $i => $p)
		{
			if($i != "ID"){
				$dat.= $i." = '".$p."'";

				if($lauf < $len)
					$dat.=" , ";
			}
			$lauf+=1;		
		}
	
		$sql="UPDATE ".$table." SET ".$dat." WHERE ID = '".$insert["ID"]."'";
	}

mysql_query($sql);

}

function delete($ID,$table){

$sql="DELETE FROM ".$table." WHERE ID = '".$ID."'";
mysql_query($sql);

}


?>