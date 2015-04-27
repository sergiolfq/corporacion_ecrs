// Transparencias

window.onload= function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
{
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters)) 
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='crop');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}

function addEvent( obj, type, fn ) {
		if (obj.addEventListener) {
			obj.addEventListener( type, fn, false );
			EventCache.add(obj, type, fn);
		}
		else if (obj.attachEvent) {
			obj["e"+type+fn] = fn;
			obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
			obj.attachEvent( "on"+type, obj[type+fn] );
			EventCache.add(obj, type, fn);
		}
		else {
			obj["on"+type] = obj["e"+type+fn];
		}
	}
		
	var EventCache = function(){
		var listEvents = [];
		return {
			listEvents : listEvents,
			add : function(node, sEventName, fHandler){
				listEvents.push(arguments);
			},
			flush : function(){
				var i, item;
				for(i = listEvents.length - 1; i >= 0; i = i - 1){
					item = listEvents[i];
					if(item[0].removeEventListener){
						item[0].removeEventListener(item[1], item[2], item[3]);
					};
					if(item[1].substring(0, 2) != "on"){
						item[1] = "on" + item[1];
					};
					if(item[0].detachEvent){
						item[0].detachEvent(item[1], item[2]);
					};
					item[0][item[1]] = null;
				};
			}
		};
	}();
	
	function $() {
		var elements = new Array();
		for (var i = 0; i < arguments.length; i++) {
			var element = arguments[i];
			if (typeof element == 'string')
				element = document.getElementById(element);
			if (arguments.length == 1)
				return element;
			elements.push(element);
		}
		return elements;
	}

	
	//addEvent(window,'load',correctPNG);
	//addEvent(window,'unload',EventCache.flush);
	//addEvent(window,'load',pageLoaders);
	

	