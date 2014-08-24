<!DOCTYPE html>
<?php
	/* /mobile/index.php
	 * Autor: Machac Philipp
	 * Version: 1.0.1
	 * Beschreibung:
	 *	Auswahlseite fuer mobile Geraete.
	 *
	 * Changelog:
	 * 	1.0.0:  31.01.2014, Machac Philipp - Erste Seite
	 *	1.0.1:	01.02.2014, Machac Philipp - Pfade angepasst
	 */
	require("../config.php");
?> 
<html>
	<head>
   		 <title>SIS.Mobile</title>
         
         <!-- Favicon -->
		 <link rel="shortcut icon" href="../favicon.ico" type="image/x-ico" />
		 <link rel="icon" href="../favicon.ico" type="image/x-ico" />
         <!-- Includes -->
		 <link rel="stylesheet" type="text/css" href="../data/styles/mobile.css" />
	</head>
    <body>    
        <div id="content">
          <h1>Mobile Apps</h1>
                <center>
                    <a href="http://www.windowsphone.com/de-at/store/app/sis/bac43498-c9dd-4b5d-aa33-d4112ee7939b" title="App f&uuml;r Windows Phone ansehen">
                        <img src="<?php echo RELATIVE_ROOT; ?>/data/images/mobile/windowsphone.png" alt="Windows Phone Store">
                    </a>
                    <a href="http://build.phonegap.com/apps/460326/install/?qr_key=RNAZb2HBmUZ8Lr1nGrSQ" title="App f&uuml;r iOS ansehen">
                        <img src="<?php echo RELATIVE_ROOT; ?>/data/images/mobile/ios.png" alt="App Store">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.SIS_App" title="App f&uuml;r Android ansehen">
                        <img src="<?php echo RELATIVE_ROOT; ?>/data/images/mobile/android.png" alt="GooglePlay Store">
                    </a>
                </center>
                    <br />
                    <br />
                    <br />
          <h1>Desktop Version</h1>
                <center>
                    <a href="<?php echo RELATIVE_ROOT; ?>/?noJS&noMobile" title="Desktop Version der Seite besuchen">
                        <img src="<?php echo RELATIVE_ROOT; ?>/data/images/mobile/desktop.png" alt="Desktop Version">
                    </a>
                    <br />
                    <br /> 
                    <br />
                    <br />
                </center>
        </div>
	</body>
</html>
