<!--

///// DEFAULT SETTINGS /////
YOffset = 50; // no quotes!!
staticYOffset = 10; // no quotes!!
slideSpeed = 1; // no quotes!!
waitTime = 1; // no quotes!! this sets the time the menu stays out for after the mouse goes off it.
hdrFontFamily = "Verdana";
hdrFontSize = "3";
hdrFontColor = "white";
hdrBGColor = "white";
hdrAlign = "right";
hdrVAlign = "center";
hdrHeight = "20";
linkFontFamily = "Verdana";
linkFontSize = "2";
linkBGColor = "white";
linkOverBGColor = "white";
linkAlign = "left";
menuBGColor = "black";
menuIsStatic = "yes";
menuWidth = 350; // Must be a multiple of 10! no quotes!!
barBGColor = "#79AFEC";
barFontFamily = "Verdana";
barFontSize = "2";
barFontColor = "black";
barVAlign = "top";
barWidth = 30; // no quotes!!


///// BROWSER DETECTION /////
NS6 = (document.getElementById && !document.all)
IE = (document.all)
NS = (navigator.appName == "Netscape" && navigator.appVersion.charAt(0) == "4")

///// SLIDE FUNCTION //////
moving = setTimeout('null', 1)
function moveOut() {
	if ((NS6 && parseInt(ssm.left) < 0) || (IE && ssm.pixelLeft < 0) || (NS && ssm.left < 0)) {
		clearTimeout(moving);
		moving = setTimeout('moveOut()', slideSpeed)
		if (NS6) {
			theleft += 10;
			ssm.left = theleft;
		}
		if (IE) {
			ssm.pixelLeft += 10;
		}
		if (NS) {
			ssm.left += 10;
			ssm.clip.left -= 10
		}
	} else {
		clearTimeout(moving);
		moving = setTimeout('null', 1);
	}
	if (divssm) {
		hideSelectBoxes(divssm, true);
	}
};
function moveBack() {
	clearTimeout(moving);
	moving = setTimeout('moveBack1()', waitTime)
}

function moveBack1() {
	if ((NS6 && parseInt(ssm.left) > (-menuWidth)) || (IE && ssm.pixelLeft > (-menuWidth)) || (NS && ssm.left > (-menuWidth))) {
		clearTimeout(moving);
		moving = setTimeout('moveBack1()', slideSpeed);
		if (divssm) {
			hideSelectBoxes(divssm, true);
		}
		if (NS6) {
			theleft -= 10;
			ssm.left = theleft;
		}
		if (IE) {
			ssm.pixelLeft -= 10;
		}
		if (NS) {
			ssm.left -= 10;
			ssm.clip.left += 10
		}
	} else {
		clearTimeout(moving);
		moving = setTimeout('null', 1)
	}
};

///// STATIC FUNCTION /////
lastY = 0;
function makeStatic() {
	if (IE) {
		winY = document.body.scrollTop;
	}
	if (NS || NS6) {
		winY = window.pageYOffset;
	}
	if (NS6 || IE || NS) {
		if (winY != lastY && winY > YOffset-staticYOffset) {
			smooth = .3 * (winY - lastY - YOffset + staticYOffset);
		}
		else if (YOffset-staticYOffset+lastY > YOffset-staticYOffset) {
			smooth = .3 * (winY - lastY);
		} else {
			smooth = 0
		}
		if (smooth > 0) smooth = Math.ceil(smooth);
		else smooth = Math.floor(smooth);
		if (NS6) ssm.top = parseInt(ssm.top)+smooth;
		if (IE) ssm.pixelTop += smooth;
		if (NS) bssm.top += smooth;
		lastY = lastY+smooth;
		setTimeout('makeStatic()', 1)
	}
}

///// SETS OBJECT NAMES AND LOADS MENU /////
function initSlide() {
	if (NS6) {
		divssm = document.getElementById("thessm");
		ssm = document.getElementById("thessm").style;
		ssm.visibility = "visible";
		ssm.left = -menuWidth;
	} else if (IE) {
		divssm = document.all("thessm");
		ssm = document.all("thessm").style;
		ssm.visibility = "visible";
		ssm.pixelLeft = -menuWidth;
	} else if (NS) {
		divssm = ssm;
		bssm = document.layers["basessm1"];
		ssm = bssm.document.layers["basessm2"].document.layers["thessm"];
		ssm.clip.left = menuWidth;
		ssm.left = -menuWidth;
		ssm.visibility = "show";
	}
	if (menuIsStatic == "yes") makeStatic();
}

///// MENU BUILDER FUNCTIONS /////
function startMenu(barText) {
	if (IE || NS6) {
		document.write('<div id="thessm" style="visibility:hidden;position:absolute;left:0px;top:'+eval(YOffset+10)+'px;z-index : 150;width:1px;clip:;" onmouseover="moveOut()" onmouseout="moveBack()">')
	}
	if (NS) {
		document.write('<layer name="basessm1" top="'+YOffset+'" left=0 visibility="show" width="'+(menuWidth+barWidth+10)+'"><ILAYER name="basessm2" width="'+(menuWidth+barWidth+20)+'"><LAYER visibility="hide" name="thessm" bgcolor="'+menuBGColor+'" left="0" onmouseover="moveOut()" onmouseout="moveBack()">')
	}
	if (NS6) {
		document.write('<table border="0" cellpadding="0" cellspacing="0" width="'+(menuWidth+barWidth+2)+'" bgcolor="'+menuBGColor+'"><TR><TD>')
	}
	document.write('<table border="0" cellpadding="0" cellspacing="1" width="'+(menuWidth+barWidth+2)+'" bgcolor="'+menuBGColor+'">');
	tempBar = '';
//	document.write('<tr><td style=\"height:1px\">&nbsp;</td>'+((!tempBar)?"":"</TR>"))
	if (barText.indexOf('<IMG') > -1) {
		tempBar = barText
	} else {
		for (i = 0; i < barText.length; i++) {
			tempBar += barText.substring(i, i+1)+"<BR>"
		}
	}
	theleft = -menuWidth
}

function endMenu() {
	document.write('<td align="center" rowspan="100" width="'+barWidth+'" bgcolor="'+barBGColor+'" valign="'+barVAlign+'" style=\"filter: progid:DXImageTransform.Microsoft.Gradient(gradientType=1,startColorStr=#DDECFE,endColorStr=#79AFEC);\"><p align="center"><font face="'+barFontFamily+'" Size="'+barFontSize+'" COLOR="'+barFontColor+'"><B>'+tempBar+'</B></font></p></TD></tr>')
	document.write('</table>')
	if (NS6) {
		document.write('</td></tr></table>')
	}
	if (IE || NS6) {
		document.write('</div>')
	}
	if (NS) {
		document.write('</layer></ilayer></layer>')
	}
	if (NS6 || IE || NS) setTimeout('initSlide();', 1)
	}


function addItem(text) {
	document.write('<TR><TD BGCOLOR="'+linkBGColor+'" onmouseover="bgColor=\''+linkOverBGColor+'\'" onmouseout="bgColor=\''+linkBGColor+'\'" WIDTH="'+(menuWidth-1)+'">'+text+'</TD>')
}

//-->