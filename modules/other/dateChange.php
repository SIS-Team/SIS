<?php

include_once(ROOT_LOCATION . "/modules/other/dateFunctions.php");

function dateChange($date){
	//print_r($_POST);
	if(isset($_POST['right']) && $_POST['right']==1) {
		$date = date_increase($date);
		//echo 1;
	}
	else if (isset($_POST['left']) && $_POST['left']==1) {
		//echo -1;
		$date = date_decrease($date);
	}

//Formular ausgeben
?>
<form method="post">
	<table >
		<tr style="vertical-align: bottom">
			<button class="nonButton" name="left" align="absmiddle" value="1">
				<?php include(ROOT_LOCATION . "/data/images/larrow.svg"); ?>
			</button>
			<?php echo weekday($date); ?> <input type="date" name="date" value="<?php echo $date; ?>" size="10">
			<button class="nonButton" name="right" align="absmiddle" value="1">
				<?php include(ROOT_LOCATION . "/data/images/rarrow.svg"); ?>
			</button>
		</tr>
	</table>
</form>
<?php
	return $date;
}
?>
