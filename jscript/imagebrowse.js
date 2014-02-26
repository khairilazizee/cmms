function hidediv() { 
if (document.getElementById) { // DOM3 = IE5, NS6 
document.getElementById('imagelist').style.visibility = 'hidden'; 
} 
else { 
if (document.layers) { // Netscape 4 
document.imagelist.visibility = 'hidden'; 
} 
else { // IE 4 
document.all.imagelist.style.visibility = 'hidden'; 
} 
} 
} 

function showdiv() { 
if (document.getElementById) { // DOM3 = IE5, NS6 
document.getElementById('imagelist').style.visibility = 'visible'; 
document.getElementById('imagelist').left=document.body.scrollLeft+event.clientX;
document.getElementById('imagelist').top=document.body.scrollLeft+event.clientY;
} 
else { 
if (document.layers) { // Netscape 4 
alert('show 1');
document.imagelist.visibility = 'visible'; 
} 
else { // IE 4 
alert('show 1');
document.all.imagelist.style.visibility = 'visible'; 
} 
} 
} 