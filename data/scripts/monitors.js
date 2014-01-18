/* /data/scripts/monitors.js
 * Autor: Buchberger Florian
 * Version: 0.1.2
 * Beschreibung:
 *	Scripts für die Monitore
 *
 * Changelog:
 *	0.1.2:	20. 09. 2013, Buchberger Florian - Bilder und Videos
 *	0.1.1:	09. 09. 2013, Buchberger Florian - Kommentare
 * 	0.1.0:  04. 09. 2013, Buchberger Florian - erste Version
 */

// enthält namen des monitors
var monitorName = "";

// enthält aktuellen hash des monitors
var monitorHash = "";

// wenn die seite läd
var main = function() {
	// lese monitor name und schreibe globale variable
	monitorName = document.getElementById("name").innerHTML;	

	// lade die uhr und aktualisiere jede Sekunde
	clockUpdate();
	window.setInterval(clockUpdate, 1000);
	// lade den Inhalt und aktualisiere alle 10 Sekunden
	loadContent();
	window.setInterval(loadContent, 10000);
	// passe die Höhe des Fensters an
	document.getElementById("main").style.height = (window.innerHeight - 70) + "px";

	window.onresize = function() {
		document.getElementById("main").style.height = (window.innerHeight - 70) + "px";
	}
}

var ret = function (v) {
	return v;
}

// aktualisiere Zeit + Datum rechts unten
var clockUpdate = function() {
	var date = new Date();
	var time = date.toLocaleTimeString().substring(0, 8);
	if (parseInt(date.getTime() / 1000) % 2 == 0)
		while (time.indexOf(":") != -1)
			time = time.replace(":", " ");
	document.getElementById("digitalClock").innerHTML = time;
	document.getElementById("date").innerHTML = date.getDate() + ". " + (date.getMonth() + 1) + ". " + date.getFullYear();
	// zeichne die analoge Uhr
	drawClock(date.getHours(), date.getMinutes());
}

// zeichne analoge Uhr
// parameter: hour -> Stunde (0 - 24), minute -> Minute (0  60)
var drawClock = function(hour, minute) {
	var canvas = document.getElementById("canvas");
	var context = canvas.getContext("2d");
	var angleHour = hour / 12 * 2 * Math.PI + Math.PI;
	var angleMinute = minute / 60 * 2 * Math.PI + Math.PI;
	// lösche alles
	context.clearRect(0, 0, canvas.width, canvas.height);
	context.save();
	context.beginPath();
	context.strokeStyle = "#fff";
	context.lineWidth = 1;
	// zeichne Uhr Rahmen
	context.arc(35, 35, 34, 0, Math.PI * 2, true);
	context.stroke();
	context.restore();
	// zeichne Stunden-Zeiger
	drawHand(context, angleHour, 22);
	// zeichne Minuten-Zeiger
	drawHand(context, angleMinute, 30);
}

// zeichne Zeiger
// Parameter: canvas-context, Winkel in rad von unten im Uhrzeigersinn, Länge des Zeigers
var drawHand = function(context, angle, length) {
	context.save();
	context.beginPath();
	context.strokeStyle = "#fff";
	context.lineCap = "round";
	context.lineWidth = 2;
	context.translate(35, 35);
	context.rotate(angle);
	context.moveTo(0, 0);
	context.lineTo(0, length);
	context.stroke();
	context.restore();
}

// registriert monitor
var register = function() {
	// TODO
}

// läd Seiteninhalt
var loadContent = function () {
	// sendet aktuellen Monitor-Hash zum Server
	reqGet("/monitors/api/getContent.php", "name=" + monitorName + "&hash=" + monitorHash, true, updateContent);
}

// aktualisiert den Seiteninhalt
var updateContent = function(response) {
	console.log(response);
	response = JSON.parse(response);
	console.dir(response);

	if (response.script)
		eval(response.script);
	
	// Wenn Server-Fehler -> generiere Popup
	if (response.error.length) {
		makeError("server", "Server Message", response.error);
		return;
	}

	// Wenn kein Fehler -> Popup entfernen
	removeError("server");

	// Wenn sich der Inhalt nicht geändert hat (Server-Hash == Client-Hash) -> abbrechen
	if (!response.changes) // keine änderungen
		return;
	
	// Wenn nicht -> Hash updaten
	monitorHash = response.hash;
	
	// Medien-URLs einfügen
	var text = getMedia(response);
	// ausgeben
	document.getElementById("main").innerHTML = text;
	
	var infotext = response.info;
	document.getElementById("infotext").innerHTML = infotext;
}

// führt GET request durch
// file  -> auszurufende Datei
// pars  -> GET-Parameter (ohne ?)
// bg    -> Bei false wartet die Funktion auf die Antwort
// after -> Auszuführende Funktion bei Antwort
var reqGet = function(file, pars, bg, after) {
	var http = new XMLHttpRequest();
	http.open("GET", file + "?" + pars, bg);
	if (bg) {
		http.onreadystatechange = function() {
			if (http.readyState == 4) {
				after(http.responseText);
			}
		};
	}
	http.send(null);
	if (!bg) 
		return after(http.responseText);
}

// führt POST request durch
// file  -> auszurufende Datei
// get   -> GET-Parameter (ohne ?)
// pars  -> POST-Parameter
// bg    -> Bei false wartet die Funktion auf die Antwort
// after -> Auszuführende Funktion bei Antwort
var reqPost = function(file, get, pars, bg, after) {
	var http = new XMLHttpRequest();
	http.open("POST", file + "?" + get, bg);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", pars.length);
	http.setRequestHeader("Connection", "close")
	if (bg) {
		http.onreadystatechange = function() {
			if (http.readyState == 4) {
				after(http.responseText);
			}
		};
	}
	http.send(pars);
	if (!bg) 
		return after(http.responseText);
}

// generiert Popup
// id wird zum löschen des Popups verwendet
var makeError = function(id, title, message) {
	var old = document.getElementById(id);
	if (old) {
		old.innerHTML = '<div class="title"><img onclick="removeError(\'' + id + '\')" src="/data/images/error.png"></img>' + title + '</div>' + message;
		return;
	}
	var text = '<div style="top: ' + parseInt(-Math.random() * 200) + 'px; left: ' + parseInt(-Math.random() * 300) + 'px" id="' + id + '" class="error"><div class="title"><img onclick="removeError(\'' + id + '\')" src="/data/images/error.png"></img>' + title + '</div>' + message + "</div>";
	document.getElementById("errors").innerHTML += text;
}

// löscht alle Popups
var clearErrors = function () {
	document.getElementById("errors").innerHTML = "";
}

// löscht Popup über ID
var removeError = function (id) {
	try {
		document.getElementById(id).remove();
	} catch (e) {
	}
}

// bindet die Media-URLs in den Seiteninhalt ein.
var getMedia = function (response) {
	var text = response.content;
	for (var i in response.media) {
		text = text.replace("&media:" + i + ";", "/monitors/media/" + response.media[i]);
	}
	return text;
}
