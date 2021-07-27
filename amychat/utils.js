function getAjaxRequest() {
	var ajaxRequest = null;
	try {
		ajaxRequest = new XMLHttpRequest();
	} catch (e) {
		try {
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				alert("You browser does not support AJAX.  This website will not work!");
			}
		}
	}
 	return ajaxRequest;
}

function getElement(elementId) {
	if (document.getElementById) {
		return document.getElementById(elementId);
	} else if (document.all) {
		return document.all[elementId];
	} else if (document.layers) {
		return document.layers[elementId];
	}
}

function getStyle(elementId, cssProperty) {
	var element = getElement(elementId);
	var strValue = "";
	if (document.defaultView && document.defaultView.getComputedStyle) {
		strValue = document.defaultView.getComputedStyle(element,null).getPropertyValue(cssProperty);
	} else if (elementId.currentStyle) {
		cssProperty = cssProperty.replace(/\-(\w)/g, function (strMatch, p1){
			return p1.toUpperCase();
		});
		strValue = oElm.currentStyle[strCssRule];
	}
	
	return strValue;
}

function setCookie(cookieName,cookieValue,daysToExpire) {
	var exDate = new Date();
	exDate.setDate(exDate.getDate() + daysToExpire);
	document.cookie=cookieName + "=" + escape(cookieValue) +
		((daysToExpire == null) ? "" : ";expires=" + exDate.toGMTString());
}

function getCookie(cookieName) {
	var cookieValue = "";
	if (document.cookie.length > 0) {
		var nameStart = document.cookie.indexOf(cookieName + "=");
		if (nameStart != -1) {
			var valueStart = nameStart + cookieName.length + 1;
			var valueEnd = document.cookie.indexOf(";",valueStart);
			if (valueEnd == -1) {
				valueEnd = document.cookie.length;
			}
			cookieValue = unescape(document.cookie.substring(valueStart, valueEnd));
		}
	}
	
	return cookieValue;
}
