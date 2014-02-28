
	var urlListener = new UrlListener();
	var choice = urlListener.getGETpar("choice");
	var j = 1;
	var i = 1;
	var iOld;
	var suplObject;
	
	var test;

	$(function(){

		$.getJSON("http://sis.htlinn.ac.at/modules/api/api.php?class=" + choice +"&method=getSubstitude&jsoncallback=?",
			function(data) {
				
				console.log(data)
				console.log(j);

				for(aSubstitude in data){					
					var substitude = data[aSubstitude];

					console.log("startHour: " + substitude.startHour);
					console.log("Hour: " + j)
					i = substitude.startHour;
					if(j == 1)
						iOld = i;

					var newTR = document.createElement("tr");
					newTR.id = "Supplierung";
					document.getElementById("Tabelle").appendChild(newTR);
											
					var newTD = document.createElement("td");
					newTD.id = i + j + "1";
					newTR.appendChild(newTD);
					var newTD = document.createElement("td");
					newTD.id = i + j + "2";
					newTR.appendChild(newTD);
					var newTD = document.createElement("td");
					newTD.id = i + j + "3";
					newTR.appendChild(newTD);
					var newTD = document.createElement("td");
					newTD.id = i + j + "4";
					newTR.appendChild(newTD);
					var newTD = document.createElement("td");
					newTD.id = i + j + "5";
					newTR.appendChild(newTD);
					
					
					//var i = lesson.startHour + j;			
					//sdocument.write(lesson.seName);
					console.log(i + j + "1");
					document.getElementById(i + j + "1").innerHTML=substitude.time;
					document.getElementById(i + j + "2").innerHTML=substitude.startHour;
					document.getElementById(i + j + "3").innerHTML=substitude.suShort;
					document.getElementById(i + j + "4").innerHTML=substitude.teShort;
					document.getElementById(i + j + "5").innerHTML=substitude.comment;
					j++;
					if(i != iOld)
						j = 1;
				}
							
	
			}
		)
	});

	
	
