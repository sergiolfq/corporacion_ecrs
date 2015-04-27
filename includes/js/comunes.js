function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {	
		xScroll = document.body.scrollWidth;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
	
	var windowWidth, windowHeight;
	if (self.innerHeight) {	// all except Explorer
		windowWidth = self.innerWidth;
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}	
	
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else { 
		pageHeight = yScroll;
	}

	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){	
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}


	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight) 
	return arrayPageSize;
}

Object.extend(Element, {
	getWidth: function(element) {
	   	element = $(element);
	   	return element.offsetWidth; 
	},
	setWidth: function(element,w) {
	   	element = $(element);
    	element.style.width = w +"px";
	},
	setHeight: function(element,h) {
   		element = $(element);
    	element.style.height = h +"px";
	},
	setTop: function(element,t) {
	   	element = $(element);
    	element.style.top = t +"px";
	},
	setSrc: function(element,src) {
    	element = $(element);
    	element.src = src; 
	},
	setHref: function(element,href) {
    	element = $(element);
    	element.href = href; 
	},
	setInnerHTML: function(element,content) {
		element = $(element);
		element.innerHTML = content;
	}
});

function getPageScroll(){

	var yScroll;

	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
	} else if (document.documentElement && document.documentElement.scrollTop){	 // Explorer 6 Strict
		yScroll = document.documentElement.scrollTop;
	} else if (document.body) {// all other Explorers
		yScroll = document.body.scrollTop;
	}

	arrayPageScroll = new Array('',yScroll) 
	return arrayPageScroll;
}
function loadCrystalFrame(url,params){
	window.scroll(0,0);
	$('lightbox').innerHTML="<div align=\"center\"><img src=\"/images/design/ajax-loader.gif\" border=\"0\"></div>";
	var arrayPageSize = getPageSize();
	$('overlay').style.display='';
	Element.setHeight('overlay', arrayPageSize[1]);
	var arrayPageSize = getPageSize();
	var arrayPageScroll = getPageScroll();
	var lightboxTop = arrayPageScroll[1] + (arrayPageSize[3] / 15);
	Element.setTop('lightbox', lightboxTop);
	$('lightbox').style.display='none';
	
    var myAjax = new Ajax.Updater('lightbox', url, { method: 'post', evalScripts: true, parameters: params, onComplete: function(){Effect.Appear('lightbox',{duration:0.5});} });
}


function closeCrystal(){
	$('overlay').style.display='none';
	Effect.Shrink('lightbox');	
	$('lightbox').innerHTML="";
}


var eventsForPaginateAjaxResults = {
	onLoading: function() {
		$("infoPanel").innerHTML = "<br />"
		$("loading").innerHTML = "<div align=\"center\"><img src=\"/images/design/ajax-loader.gif\" border=\"0\"></div>";
		$('loading').style.display='';
		var efecto1 =Effect.SlideUp('infoPanel',{duration:0.3});	
	},
	onComplete: function() {
		$('loading').style.display='none';
		efecto2 = Effect.SlideDown('infoPanel',{duration:0.5,queue: 'end'});
	}
}


function dologin(){
	new Ajax.Request('ajax_resp/login.php',{method:'post',parameters: 'email=' + $('email').value + '&pass=' + $('pass').value,onComplete: function(obj) {
		respuesta = obj.responseText;
		if(respuesta == "2") {
			document.location='/?module=account';
			return false;
		} else {
			$('mensaje_alerta').innerHTML = "<div id='dclave' style='display: none' class='txt_general'>" + respuesta + "</div>";
			 Effect.Appear('dclave');
			 return false;
		}
	}});
	return false;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
