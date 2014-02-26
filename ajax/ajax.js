<!-- 
//Browser Support Code
function papar_periksa(kod){
	var ajaxRequest;  // The variable that makes Ajax possible!

	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
           s=ajaxRequest.responseText;
		   var arr=s.split("|");
           opener.document.getElementById("txtPeriksa").value=kod;
 		   opener.document.getElementById("divNamaPeperiksaan").innerHTML = arr[0];
 		   opener.document.getElementById("divTarikhPeperiksaan").innerHTML = arr[1];
 		   opener.document.getElementById("divTempat").innerHTML = arr[2];
 		   opener.document.getElementById("divGred").innerHTML = arr[3];
 		   opener.document.getElementById("divTK").innerHTML = arr[4];
 		   opener.document.getElementById("divSesi").innerHTML = arr[5];
           window.close();
	   }
	}
	ajaxRequest.open("GET", "ajax/papar_periksa.php?kod=" + kod, true);
	ajaxRequest.send(null); 
} //papar_periksa


