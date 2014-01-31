<?php

	define("BASE_RL", ROOT_LOCATION . "/data/images/rl.svg");
	define("BASE_LR", ROOT_LOCATION . "/data/images/lr.svg");

	$back = "";
	$headerText = "";
	$buttons = array();
	$name = "";
	
	for($i = 0; $i < 8; $i++) {
		$buttons[$i] = array();
		$buttons[$i]['displayed'] 	= false;
		$buttons[$i]['enabled'] 	= false;
		$buttons[$i]['svg'] 		= ROOT_LOCATION . "/data/images/base.svg";
		$buttons[$i]['text']		= "Button";
		$buttons[$i]['url'] 		= RELATIVE_ROOT . "/";
		$buttons[$i]['jsurl'] 		= RELATIVE_ROOT . "/";
	}

	function generateMenu() {
		global $back, $headerText, $buttons, $name;
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="<?php echo RELATIVE_ROOT; ?>/data/styles/menu.css" />
		<script src="<?php echo RELATIVE_ROOT; ?>/data/scripts/menu.js"></script>
	</head>
	<body<?php echo (!isset($_GET['noJS'])) ? ' onload="main()"' : ""; ?>>
		<div class="linkAdr" id="middleLink"><?php echo $back; ?></div>
		<div id="background" onclick="closeLink()">
		</div>
		<div id="headerCenter" class="point hCenter">
			<div id="header" class="sameWidth">
				<div id="title" class="link">
					<a href="<?php echo $back; ?>">
						<?php
							echo str_replace(" ", "<span> </span>", $headerText);
						?>
					</a>
				</div>
				<div id="userInfo" class="link">
					<?php echo $name; ?><span> | </span><a href="<?php echo RELATIVE_ROOT; ?>/logout/">Logout<a>
				</div>
			</div>
		</div>
		<div class="point vCenter hCenter">
			<div id="menuContainer" class="sameWidth">
				<div id="menuUp" class="half">
					<div class="mid">
						<?php include(ROOT_LOCATION . "/data/images/up.svg"); ?>
					</div>
					<div class="<?php echo ($buttons[2]['displayed'] ? "" : "notUsed "); ?>menuPoint menuRightLevel1">
						<?php 
							if ($buttons[2]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[2]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_LR); ?>
						<?php include($buttons[2]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[2]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[2]['url']; ?>">
								<?php echo $buttons[2]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[3]['displayed'] ? "" : "notUsed "); ?>menuPoint menuRightLevel2">
						<?php 
							if ($buttons[3]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[3]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_LR); ?>
						<?php include($buttons[3]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[3]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[3]['url']; ?>">
								<?php echo $buttons[3]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[1]['displayed'] ? "" : "notUsed "); ?>menuPoint menuLeftLevel1">
						<?php 
							if ($buttons[1]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[1]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_RL); ?>
						<?php include($buttons[1]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[1]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[1]['url']; ?>">
								<?php echo $buttons[1]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[0]['displayed'] ? "" : "notUsed "); ?>menuPoint menuLeftLevel2">
						<?php 
							if ($buttons[0]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[0]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_RL); ?>
						<?php include($buttons[0]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[0]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[0]['url']; ?>">
								<?php echo $buttons[0]['text']; ?>
							</a>
						</div>
					</div>
				</div>
				<div id="menuDown" class="half">
					<div class="mid">
						<?php include(ROOT_LOCATION . "/data/images/down.svg"); ?>
					</div>
					<div class="<?php echo ($buttons[6]['displayed'] ? "" : "notUsed "); ?>menuPoint menuRightLevel1">
						<?php 
							if ($buttons[6]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[6]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_RL); ?>
						<?php include($buttons[6]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[6]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[6]['url']; ?>">
								<?php echo $buttons[6]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[7]['displayed'] ? "" : "notUsed "); ?>menuPoint menuRightLevel2">
						<?php 
							if ($buttons[7]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[7]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_RL); ?>
						<?php include($buttons[7]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[7]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[7]['url']; ?>">
								<?php echo $buttons[7]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[5]['displayed'] ? "" : "notUsed "); ?>menuPoint menuLeftLevel1">
						<?php 
							if ($buttons[5]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[5]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_LR); ?>
						<?php include($buttons[5]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[5]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[5]['url']; ?>">
								<?php echo $buttons[5]['text']; ?>
							</a>
						</div>
					</div>
					<div class="<?php echo ($buttons[4]['displayed'] ? "" : "notUsed "); ?>menuPoint menuLeftLevel2">
						<?php 
							if ($buttons[4]['enabled']) {
								echo '<div class="linkAdr">' . $buttons[4]['jsurl'] . '</div>';
							}
						?>
						<?php include(BASE_LR); ?>
						<?php include($buttons[4]['svg']); ?>
						<div class="subtext">
							<a<?php echo ($buttons[4]['enabled'] ? "" : 'class="noLink"'); ?> href="<?php echo $buttons[4]['url']; ?>">
								<?php echo $buttons[4]['text']; ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="footerCenter" class="point hCenter">
			<div id="footer" class="sameWidth link">
				<a href="<?php echo RELATIVE_ROOT; ?>/impressum/">Impressum</a> | <a href="<?php echo RELATIVE_ROOT; ?>/impressum/#privacy">Datenschutz</a> | <a href="<?php echo RELATIVE_ROOT; ?>/impressum/#terms">Nutzungsbedingungen</a> | <a href="<?php echo RELATIVE_ROOT; ?>/help/">Hilfe</a>
			</div>
		</div>
		<div id="windowContainer">
			<div id="innerWindow">
			</div>
		</div>
	</body>
</html>
<?php
	}
?>
