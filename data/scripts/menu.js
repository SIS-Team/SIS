var Exception = function() {

}

window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;

var animation = function() {
}
animation.block = false;
animation.start = null;
animation.lastTimestamp = 0;
animation.windowDistance = parseInt(72 / 2);
animation.targetDistance = parseInt(window.innerHeight) / 2 - 30;
animation.distance = 0;
animation.open = function(timestamp) {
	animation.block = true;
	
	if (timestamp === undefined) {
		window.requestAnimationFrame(animation.open);
		return;
	}
	
	if (animation.start === null) {
 		animation.start = timestamp;
		animation.lastTimestamp = timestamp;
	}
	
	if (animation.distance > animation.windowDistance) {
		var innerWindow = document.getElementById("innerWindow");
		var diff = parseInt(animation.distance - animation.windowDistance);
		innerWindow.style.height = 2 * diff + "px";
		innerWindow.style.bottom = (- diff) + "px";
		innerWindow.style.display = "block";
	}
	move(animation.distance);

	if (animation.distance < animation.targetDistance)
		window.requestAnimationFrame(animation.open);
	else {
		animation.start = null;
		animation.block = false;
		animation.distance = animation.targetDistance;
		
		var innerWindow = document.getElementById("innerWindow");
		var diff = parseInt(animation.distance - animation.windowDistance);
		innerWindow.style.height = 2 * diff + "px";
		innerWindow.style.bottom = (- diff) + "px";
		innerWindow.style.display = "block";
		
		move(animation.distance);
		
		if (animation.after)
			animation.after();
		animation.after = false;
		return;
	}
	animation.distance += (timestamp - animation.lastTimestamp) / 2;
	animation.lastTimestamp = timestamp;
}

animation.close = function(timestamp) {
	animation.block = true;
	
	if (timestamp === undefined) {
		window.requestAnimationFrame(animation.close);
		return;
	}
	
	if (animation.start === null) {
 		animation.start = timestamp;
		animation.lastTimestamp = timestamp;
	}
	
	if (animation.distance > animation.windowDistance) {
		var innerWindow = document.getElementById("innerWindow");
		var diff = parseInt(animation.distance - animation.windowDistance);
		innerWindow.style.height = 2 * diff + "px";
		innerWindow.style.bottom = (- diff) + "px";
	} else {
		var innerWindow = document.getElementById("innerWindow");
		innerWindow.style.height = 0 + "px";
		innerWindow.style.display = "none";
	}
	move(animation.distance);

	if (animation.distance > 0)
		window.requestAnimationFrame(animation.close);
	else {
		animation.start = null;
		animation.distance = 0;
		move(0);
		animation.block = false;
		if (animation.after)
			animation.after();
		animation.after = false;
		return;
	}
	animation.distance -= (timestamp - animation.lastTimestamp) / 2;
	animation.lastTimestamp = timestamp;
}

var move = function(x) {
	x = parseInt(x);
	document.getElementById("menuUp").style.top = -x + "px";
	document.getElementById("menuDown").style.bottom = -x + "px";
	document.getElementById("header").style.top = -x + "px";
	document.getElementById("footer").style.bottom = -x + "px";
}

var closeLink = function() {
	if (animation.block)
		return;
	animation.close();
}

var openLink = function(link) {	
	if (animation.block)
		return;
	if (animation.distance > 0) {
		eval("var tmp = function() { openLink('" + link + "'); }");
		animation.after = tmp;
		animation.close();
		return;
	}
	
	var menu = link.split("?");
	if (menu[1]) {
		menu = menu[1].split("&");
		for (var i = 0; i < menu.length; i++) {
			if (menu[i] == "menu") {
				location.href = link;
				return;
			}
		}
	}
	
	animation.open();
	link = link.split("#")
	document.getElementById("innerWindow").innerHTML = "<iframe src='" + link[0] + "'>Ihr Browser unterstützt keine iFrames, drücken Sie bitte <a href='" + link.join("#") + "'>hier</a></iframe>";
	var tmp;
	eval('tmp = function () {\
		var frame = document.getElementById("innerWindow").getElementsByTagName("iframe")[0].contentWindow;\
		' + ((link.length > 1) ? 'frame.scope = frame;\
		frame.setTimeout(function() {\
			frame.smoothScroll("' + link[1] + '");\
		}, 500);' : "") + '\
		frame.document.getElementById("closeLink").href = "javascript:parent.closeLink()";\
	}');
	document.getElementById("innerWindow").getElementsByTagName("iframe")[0].onload = tmp;
}

var hoverLink = function(half, row) {
	var row = document.getElementsByClassName("half")[half].getElementsByClassName("menuPoint")[row];
	row.getElementsByTagName("g")[1].attributes["fill"].value = "#ccc";
	row.getElementsByTagName("g")[1].style.opacity = 0.3;
	row.getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].style.color = "#000";
}

var dehoverLink = function(half, row) {
	var row = document.getElementsByClassName("half")[half].getElementsByClassName("menuPoint")[row];
	row.getElementsByTagName("g")[1].attributes["fill"].value = "#000";
	row.getElementsByTagName("g")[1].style.opacity = 1;
	row.getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].style.color = "#fff";
}

var hoverLinkMiddle = function () {
	var tmp = document.getElementsByClassName("half")[0].getElementsByClassName("mid")[0].getElementsByTagName("g")[0];
	tmp.attributes["fill"].value = "#ccc";
	tmp.style.opacity = 0.5;
	tmp = document.getElementsByClassName("half")[1].getElementsByClassName("mid")[0].getElementsByTagName("g")[0];
	tmp.attributes["fill"].value = "#ccc";
	tmp.style.opacity = 0.5;
}

var dehoverLinkMiddle = function () {
	var tmp = document.getElementsByClassName("half")[0].getElementsByClassName("mid")[0].getElementsByTagName("g")[0];
	tmp.attributes["fill"].value = "#000";
	tmp.style.opacity = 1;
	tmp = document.getElementsByClassName("half")[1].getElementsByClassName("mid")[0].getElementsByTagName("g")[0];
	tmp.attributes["fill"].value = "#000";
	tmp.style.opacity = 1;
}

var checkMobile = function(root) {
	if (isMobile()) {
		window.location.href = root + "/mobile/";
		throw new Exception();
	}
}

var main = function() {
	var halfs = document.getElementsByClassName("half");
	for (var i = 0; i < halfs.length; i++) {
		var rows = halfs[i].getElementsByClassName("menuPoint");
		for (var e = 0; e < rows.length; e++) {
			if (rows[e].getElementsByClassName("linkAdr").length == 0)
				continue;
			var link = rows[e].getElementsByClassName("linkAdr")[0].innerHTML;
			while (link.indexOf("&amp;") != -1) // just don't ask
				link = link.replace("&amp;", "&");
			console.log("link: " + link);
			rows[e].getElementsByTagName("g")[0].setAttribute("onclick", "openLink('" + link + "')");
			rows[e].getElementsByTagName("g")[0].setAttribute("onmouseenter", "hoverLink(" + i + ", " + e + ")");
			rows[e].getElementsByTagName("g")[0].setAttribute("onmouseleave", "dehoverLink(" + i + ", " + e + ")");
			rows[e].getElementsByTagName("g")[0].style.cursor = "pointer";		
			rows[e].getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].setAttribute("href", "javascript:openLink('" + link + "')");
			rows[e].getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].style.cursor = "pointer";
			rows[e].getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].setAttribute("onmouseenter", "hoverLink(" + i + ", " + e + ")");
			rows[e].getElementsByClassName("subtext")[0].getElementsByTagName("a")[0].setAttribute("onmouseleave", "dehoverLink(" + i + ", " + e + ")");
		}
		var mid = halfs[i].getElementsByClassName("mid")[0];
		var link = document.getElementById("middleLink").innerHTML;
		mid.getElementsByTagName("g")[0].setAttribute("onclick", "window.location.href = '" + link + "';");
		mid.getElementsByTagName("g")[0].setAttribute("onmouseenter", "hoverLinkMiddle()");
		mid.getElementsByTagName("g")[0].setAttribute("onmouseleave", "dehoverLinkMiddle()");
		mid.getElementsByTagName("g")[0].style.cursor = "pointer";	
	}

	var array = document.getElementById("footer").getElementsByTagName("a");
	for (var i = 0; i < array.length; i++) {
		array[i].setAttribute("href", "javascript:openLink('" + array[i].href + "')");
	}
}
