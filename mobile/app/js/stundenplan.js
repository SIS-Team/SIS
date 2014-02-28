	var urlListener = new UrlListener();

	var username = urlListener.getHASHpar("username");
	urlListener.deleteHASHpar("username");
	var password = urlLobject;istener.getHASHpar("password");
	urlListener.deleteHASHpar("password");



	var choice;
	var query;

	var zahl = <?php echo $zahl; ?>;

$( document ).ready(function() {
	$('.evening').css('display', 'none');
});


	query = "https://sis.htlinn.ac.at/modules/api/api.php?username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password) + "&method=loginApp&jsoncallback=?";

	$(function(){

		$.getJSON(query,
			function(data) {
				if (data.error) {
					window.location.href = "index.html#&error=" + encodeURIComponent(data.error);
					return;
				}

				else{
					//query = "https://sis.htlinn.ac.at/modules/api/api.php?method=getLessonsByClasse&jsoncallback=?";

					object = data;


					for(aLesson in object){					
						var lesson = object[aLesson];
						switch(lesson.weekdayShort)
						{
						case "Mo":
						  var day = 1;
						  break;
						case "Di":
						  var day = 2;
						  break;
						  case "Mi":
						  var day = 3;
						  break;
						case "Do":
						  var day = 4;
						  break;
						  case "Fr":
						  var day = 5;
						  break;
						
						}
						
						var start = lesson.startHour;
						var cell = day + start;			
						//sdocument.write(lesson.seName);
												
						for(;parseInt(start) <= lesson.endHour; start=parseInt(start) + 1)
						{
							
							var cell = "" + day + start;

							object[aLesson].cellid = object[aLesson].cellid + cell  + "/";

							if(document.getElementById(cell).innerHTML.indexOf(lesson.suShort) == -1 )
							{
								if(document.getElementById(cell).innerHTML == "")
									var Lesson = lesson.suShort;
								else
									var Lesson = document.getElementById(cell).innerHTML + " | " + lesson.suShort;
								
								document.getElementById(cell).innerHTML=Lesson;
							}
							
							
						}

						start = start - 1;//start ist um 1 zu groß wegen for-Schleife
						//Wenn ein Eintrag nach der 11. Stunde existiert --> Abendschule --> nur Abend einblenden
						if(start >= 12 && choice != 0){
							$( document ).ready(function() {
								$('.normal').css('display', 'none');
								$('.evening').css('display', 'table-row');
							});
						}
						else if(start >= 12 && choice == 0){
							$( document ).ready(function() {
								$('.normal').css('display', 'table-row');
								$('.evening').css('display', 'table-row');
							});
						}
						//Wenn kein Eintrage nach der 11. Stunde --> normaler Unterricht --> Abend ausblenden
						/*else{
							$( document ).ready(function() {
								$('.evening').css('display', 'none');
							});
						}*/
						choice = lesson.clName;
						
					}
								
				}

				console.log(data)
				if(choice != 0)
					document.getElementById("class").innerHTML="Stundenplan "+choice;
				else
					document.getElementById("class").innerHTML="Studnenplan "+teacher;
				
				//$.getJSON(query, makeTimetable);
			}
		)

		/*$.getJSON(query,
		function(data){

			console.log(data);

			object = data;

			for(aLesson in object){					
				var lesson = object[aLesson];
				switch(lesson.weekdayShort)
				{
				case "Mo":
				  var day = 1;
				  break;
				case "Di":
				  var day = 2;
				  break;
				  case "Mi":
				  var day = 3;
				  break;
				case "Do":
				  var day = 4;
				  break;
				  case "Fr":
				  var day = 5;
				  break;
				
				}
				
				var start = lesson.startHour;
				var cell = day + start;			
				//sdocument.write(lesson.seName);
										
				for(;parseInt(start) <= lesson.endHour; start=parseInt(start) + 1)
				{
					
					var cell = "" + day + start;

					object[aLesson].cellid = object[aLesson].cellid + cell  + "/";

					if(document.getElementById(cell).innerHTML.indexOf(lesson.suShort) == -1 )
					{
						if(document.getElementById(cell).innerHTML == "")
							var Lesson = lesson.suShort;
						else
							var Lesson = document.getElementById(cell).innerHTML + " | " + lesson.suShort;
						
						document.getElementById(cell).innerHTML=Lesson;
					}
					
					
				}

				start = start - 1;//start ist um 1 zu groß wegen for-Schleife
				//Wenn ein Eintrag nach der 11. Stunde existiert --> Abendschule --> nur Abend einblenden
				if(start >= 12 && choice != 0){
					$( document ).ready(function() {
						$('.normal').css('display', 'none');
						$('.evening').css('display', 'table-row');
					});
				}
				else if(start >= 12 && choice == 0){
					$( document ).ready(function() {
						$('.normal').css('display', 'table-row');
						$('.evening').css('display', 'table-row');
					});
				}
				//Wenn kein Eintrage nach der 11. Stunde --> normaler Unterricht --> Abend ausblenden
				else{
					$( document ).ready(function() {
						$('.evening').css('display', 'none');
					});
				}
				
			}


		});*/
	});


