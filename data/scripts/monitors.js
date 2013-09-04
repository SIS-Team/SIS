/* /data/scripts/monitors.js
 * Autor: Buchberger Florian
 * Version: 0.1.0
 * Beschreibung:
 *	Scripts für die Monitore
 *
 * Changelog:
 * 	0.1.0:  04. 09. 2013, Buchberger Florian - erste Version
 */

var main = function() {
	window.setInterval(clockUpdate, 1000);
	document.getElementById("main").style.height = (window.innerHeight - 70) + "px";
}

var clockUpdate = function() {
	var date = new Date();
	var time = date.toLocaleTimeString().substring(0, 8);
	if (parseInt(date.getTime() / 1000) % 2 == 0)
		while (time.indexOf(":") != -1)
			time = time.replace(":", " ");
	document.getElementById("digitalClock").innerHTML = time;
	document.getElementById("date").innerHTML = date.getDate() + ". " + (date.getMonth() + 1) + ". " + date.getFullYear();
	drawClock(date.getHours(), date.getMinutes());
}

var drawClock = function(hour, minute) {
	var canvas = document.getElementById("canvas");
	var context = canvas.getContext("2d");
	var angleHour = hour / 12 * 2 * Math.PI + Math.PI;
	var angleMinute = minute / 60 * 2 * Math.PI + Math.PI;
	context.clearRect(0, 0, canvas.width, canvas.height);
	context.save();
	context.beginPath();
	context.strokeStyle = "#fff";
	context.lineWidth = 1;
	context.arc(35, 35, 34, 0, Math.PI * 2, true);
	context.stroke();
	context.restore();
	drawHand(context, angleHour, 22);
	drawHand(context, angleMinute, 30);
}

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
