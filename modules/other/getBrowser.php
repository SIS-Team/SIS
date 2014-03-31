<?php

function getBrowser($user_agent) {

    $visitor_user_agent = $user_agent;
    $bname = 'Unknown';

    if (eregi('Firefox', $visitor_user_agent)) {
        $bname = 'Mozilla Firefox';
    } else if (eregi('Chrome', $visitor_user_agent)) {
        $bname = 'Google Chrome';
    } else if (eregi('Safari', $visitor_user_agent) && !eregi('Android', $visitor_user_agent)) {
        $bname = 'Apple Safari';
    } else if (eregi('Opera', $visitor_user_agent)) {
        $bname = 'Opera';
    } else if (eregi('Netscape', $visitor_user_agent)) {
        $bname = 'Netscape';
    } else if (eregi('Seamonkey', $visitor_user_agent)) {
        $bname = 'Seamonkey';
    } else if (eregi('Konqueror', $visitor_user_agent)) {
        $bname = 'Konqueror';
    } else if (eregi('Navigator', $visitor_user_agent)) {
        $bname = 'Navigator';
    } else if (eregi('Mosaic', $visitor_user_agent)) {
        $bname = 'Mosaic';
    } else if (eregi('Lynx', $visitor_user_agent)) {
        $bname = 'Lynx';
    } else if (eregi('Amaya', $visitor_user_agent)) {
        $bname = 'Amaya';
    } else if (eregi('Omniweb', $visitor_user_agent)) {
        $bname = 'Omniweb';
    } else if (eregi('Avant', $visitor_user_agent)) {
        $bname = 'Avant';
    } else if (eregi('Camino', $visitor_user_agent)) {
        $bname = 'Camino';
    } else if (eregi('Flock', $visitor_user_agent)) {
        $bname = 'Flock';
    } else if (eregi('AOL', $visitor_user_agent)) {
        $bname = 'AOL';
    } else if (eregi('AIR', $visitor_user_agent)) {
        $bname = 'AIR';
    } else if (eregi('Fluid', $visitor_user_agent)) {
        $bname = 'Fluid';
    } else if(eregi('IE',$visitor_user_agent) || eregi('trident',$visitor_user_agent)){
        $bname = 'Internet Explorer';
    } else if(eregi('Android',$visitor_user_agent) && eregi('Safari',$visitor_user_agent)){
        $bname = 'Android Browser';
    } else {
   		$bname = 'Other';
    }
	
	$os_platform ="Other";

    if (preg_match('/windows|win32/i', $visitor_user_agent)) {
        $os_platform    =   'Windows';
        if (preg_match('/phone/i', $visitor_user_agent)) {
        	$os_platform    .=  " Phone";
        }
    } else if (preg_match('/macintosh|mac os x/i', $visitor_user_agent)) {
        $os_platform    =   'Mac OS X';
    } else if (preg_match('/linux/i', $visitor_user_agent)) {
        $os_platform    =   "Linux";
    }

    if (preg_match('/iphone/i', $visitor_user_agent)) {
        $os_platform    =   "iPhone";
    } else if (preg_match('/android/i', $visitor_user_agent)) {
        $os_platform    =   "Android";
    } else if (preg_match('/blackberry/i', $visitor_user_agent)) {
        $os_platform    =   "BlackBerry";
    } else if (preg_match('/webos/i', $visitor_user_agent)) {
        $os_platform    =   "Mobile";
    } else if (preg_match('/symbOS/i', $visitor_user_agent)) {
        $os_platform    =   "Symbian";
    } else if (preg_match('/ipod/i', $visitor_user_agent)) {
        $os_platform    =   "iPod";
    } else if (preg_match('/ipad/i', $visitor_user_agent)) {
        $os_platform    =   "iPad";
    }
 	
    return array('name' => $bname,'os' => $os_platform);
}


?>
