var animation = function() {
}
animation.block = false;
animation.windowDistance = parseInt(72 / 2);
animation.targetDistance = parseInt(window.innerHeight) / 2 - 30;
animation.distance = 0;
animation.open = function() {
	animation.block = true;
	if (animation.distance > animation.windowDistance) {
		var innerWindow = document.getElementById("innerWindow");
		var diff = animation.distance - animation.windowDistance;
		innerWindow.style.height = 2 * diff + "px";
		innerWindow.style.bottom = (- diff) + "px";		
		innerWindow.style.display = "block";
	}
	move(animation.distance);

	if (animation.distance < animation.targetDistance)
		window.setTimeout(animation.open, 10);
	else
		animation.block = false;
	animation.distance += 5;
}

animation.close = function() {
	animation.block = true;
	if (animation.distance > animation.windowDistance) {
		var innerWindow = document.getElementById("innerWindow");
		var diff = animation.distance - animation.windowDistance;
		innerWindow.style.height = 2 * diff + "px";
		innerWindow.style.bottom = (- diff) + "px";
	} else {
		var innerWindow = document.getElementById("innerWindow");
		innerWindow.style.height = 0 + "px";
		innerWindow.style.display = "none";
	}
	move(animation.distance);

	if (animation.distance >= 0)
		window.setTimeout(animation.close, 10);
	else {
		animation.distance = 0;
		move(0);
		animation.block = false;
		return;	
	}

	animation.distance -= 5;
}

var move = function(x) {
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
	animation.open();
	document.getElementById("innerWindow").innerHTML = "<iframe src='" + link + "'>Ihr Browser unterstützt keine iFrames, drücken Sie bitte <a href='" + link + "'>hier</a></iframe>";
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

var main = function() {
	var halfs = document.getElementsByClassName("half");
	for (var i = 0; i < halfs.length; i++) {
		var rows = halfs[i].getElementsByClassName("menuPoint");
		for (var e = 0; e < rows.length; e++) {
			if (rows[e].getElementsByClassName("linkAdr").length == 0)
				continue;
			var link = rows[e].getElementsByClassName("linkAdr")[0].innerHTML;		
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
}
