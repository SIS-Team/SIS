$( document ).ready(function() {
		$('.openPopup').on("click", function() {

			var id = $(this).attr('id');

			var info = "";
			document.getElementById("popupID").innerHTML = info;

			for(aLesson in timetObject){
            
				if(timetObject[aLesson].cellid.indexOf(id + "/") != -1)
				{	
					if(actualClass != 0)
						var infoPart = timetObject[aLesson].teShort;
					else
						var infoPart = timetObject[aLesson].clName;
					/*alert(object[aLesson].suShort);*/

					var infoNew = "<b>" + timetObject[aLesson].suShort + "</b> <br>" + infoPart + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + timetObject[aLesson].roName;
					if(document.getElementById("popupID").innerHTML != "")
						var info = document.getElementById("popupID").innerHTML + "<br>" + infoNew;
					else
						var info = infoNew;

					document.getElementById("popupID").innerHTML = info;		
				}
			}

		    $('.Popup').fadeIn("slow");
		    $('#overlay').fadeIn("slow");
		    $('body').css('overflow', 'hidden');
		    var top = document.body.scrollTop;
		    $('.Popup').css('top', document.body.scrollTop);

	    return false;
		});
		$('.closePopup').on("click", function() {
		    $(".Popup").fadeOut("slow");
		    $("#overlay").fadeOut("slow");
	    	$('body').css('overflow', 'auto');
		    return false;
		});
	});