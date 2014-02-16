<?php

function ifNotLoggedInGotoLogin(){	
	header("Location: ".RELATIVE_ROOT."/");
	exit();
	
}

?>