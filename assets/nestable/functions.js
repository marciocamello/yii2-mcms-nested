function lagXHRobjekt() {
	var XHRobjekt = null;
	
	try {
		ajaxRequest = new XMLHttpRequest(); // Firefox, Opera, ...
	} catch(err1) {
		try {
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP"); // Noen IE v.
		} catch(err2) {
			try {
					ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP"); // Noen IE v.
			} catch(err3) {
				ajaxRequest = false;
			}
		}
	}
	return ajaxRequest;
}


function menu_updatesort(jsonstring) {
	mittXHRobjekt = lagXHRobjekt();

	if (mittXHRobjekt) {
		mittXHRobjekt.onreadystatechange = function() {
			if(ajaxRequest.readyState == 4){
				var ajaxDisplay = document.getElementById('sortDBfeedback');
				ajaxDisplay.innerHTML = ajaxRequest.responseText;
			} else {
				// Uncomment this an refer it to a image if you want the loading gif
				//document.getElementById('sortDBfeedback').innerHTML = "<img style='height:11px;' src='images/ajax-loader.gif' alt='ajax-loader' />";
			}
		}

		ajaxRequest.open("GET", baseUrl + "admin/Nestable?tableId="+ tableId +"&jsonstring=" + jsonstring + "&rand=" + Math.random()*9999, true);
		ajaxRequest.send(null);
	}
}