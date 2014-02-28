function UrlListener () {
	// V 1.2
	this.getPage = function () {
		return this.getHASHpar("page");
	}
	this.getGETpar = function (par) {
		return this.parseArg(location.search.substr(1), par);
	}
	this.getHASHpar = function (par) {
		return this.parseArg(location.hash.substr(1), par)
	}
	this.checkHash = function () {
		if (this.getPage() === false) {
			location.replace(("" + window.location).split('#')[0] + location.hash + "&page=0");
		}
	}
	this.deleteHASHpar = function (name) {
		var array = location.hash.split("&");
		var newHash = "";
		for (var i = 0; i < array.length; i++) {
			if (array[i].indexOf("=") == -1) continue;
			var tmp = array[i].split("=");
			if (tmp[0] != name) {
				newHash += "&" + tmp[0] + "=" + tmp[1];
			}
		}
		location.replace(("" + window.location).split('#')[0] + "#" + newHash);
	}
	this.parseArg = function (args, par) {
		var array = args.split("&");
		for (var i = 0; i < array.length; i++) {
			var tmp = array[i].split("=");
			if (tmp[0] == par) {
				return tmp[1];
			}
		}
		return false;
	}
	this.setPage = function (value) {
		this.setHASHpar("page", value);
	}
	this.setHASHpar = function (par, value) {
		var args = location.hash;
		if (this.getHASHpar(par) === false) {
			location.replace(("" + window.location).split('#')[0] + ((location.hash == "") ? "#" : location.hash) + "&" + par + "=" + value);
			return;
		}
		var args = args.substr(1);
		//console.log(args);
		var array = args.split("&");
		var length = 0;
		for (var i = 0; i < array.length; i++) {
			if (array[i] == "") {
				//length += 1;
				continue;
			}
			//console.log(array[i]);
			var tmp = array[i].split("=");
			//console.log(tmp[0]);
			//console.log(tmp[1]);
			length += tmp[0].length;
			if (tmp[0] == par) {
				//console.log(length);
				var top = args.substr(0, length + i + 1);
				//console.log(top);
				var bottom = args.substr(length + tmp[1].length + i + 1);
				//console.log(bottom);
				location.replace(("" + window.location).split('#')[0] + "#" + top + value + bottom);
			} else {
				//console.log("Och");
				length += tmp[1].length + 1;
			}
		}
	}
	this.setCookie = function (name, value, expdays) {
		var expdate = new Date();
		expdate.setDate(expdate.getDate() + expdays);
		value = escape(value) + ((expdays == undefined) ? "" : "; expires=" + expdate.toUTCString());
		document.cookie = name + "=" + value;
	}
	this.getCookie = function (name) {
		var start = 0;		
		if ((start = document.cookie.indexOf(name + "=")) == -1)
			return false;
		var end = 0;
		var searchString = "";		
		if ((end = document.cookie.indexOf(";", start)) == -1)
			searchString = document.cookie.substring(start);
		else
			searchString = document.cookie.substring(start, end);
		return unescape(searchString.substring(searchString.indexOf("=") + 1));
	}
	this.removeCookie = function (name) {
		this.setCookie(name, "nothing", -1)
	}
}
