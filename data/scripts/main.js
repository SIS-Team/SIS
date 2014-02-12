/*
 * Für das Scrollen habe ich prinzipiell dieses Script verwendet:
 * 
 * http://www.itnewb.com/tutorial/Creating-the-Smooth-Scroll-Effect-with-JavaScript
 * 
 */

var scope = window;

function currentYPosition() {
	if (scope.pageYOffset) 
		return scope.pageYOffset;
	if (scope.document.documentElement && scope.document.documentElement.scrollTop)
		return scope.document.documentElement.scrollTop;
	if (scope.document.body.scrollTop) 
		return scope.document.body.scrollTop;
	return 0;
} 

function elmYPosition(anchorName) {
	var elm = scope.document.getElementById(anchorName);
	var y = elm.offsetTop;
	var node = elm;
	while (node.offsetParent && node.offsetParent != scope.document.body) {
		node = node.offsetParent;
		y += node.offsetTop;
	}
	return y;
}

function smoothScroll(anchorName) {
	var startY = currentYPosition();
	var stopY = elmYPosition(anchorName);
	var distance = (stopY > startY) ? (stopY - startY) : (startY - stopY);
	if (distance < 100) {
		scrollTo(0, stopY);
		return;
	}
	var speed = Math.round(distance / 100);
	if (speed >= 20) 
		speed = 20;
	var step = Math.round(distance / 25);
	var leapY = (stopY > startY) ? (startY + step) : (startY - step);
	var timer = 0;
	if (stopY > startY) {
		for (var i = startY; i < stopY; i += step) {
			setTimeout("scope.scrollTo(0, " + leapY + ")", timer * speed);
			leapY += step; 
			if (leapY > stopY) 
				leapY = stopY; 
			timer++;
		} 
		return;
	}	
	for (var i = startY; i > stopY; i -= step) {
		setTimeout("scope.scrollTo(0, " + leapY + ")", timer * speed);
		leapY -= step; 
		if (leapY < stopY) 
			leapY = stopY; 
		timer++;
	}
}