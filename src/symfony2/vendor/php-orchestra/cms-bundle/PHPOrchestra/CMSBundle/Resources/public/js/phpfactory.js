function OpenPopup(strPageURL, i_width, i_height, str_name) {
	window.open(strPageURL, str_name, 'width=' + i_width + ',height='
			+ i_height + ',resizable=yes,scrollbars=yes,status=no');
}

function verife_id() {
	if (event.keyCode == 13) {
		filtre_index(document.formBouton.recherche_id);
	}
}

function orderFolder(direction) {
	if (lastMenu["id"]) {
		document.location.href = vTransactionPath
				+ "?form_name=page&form_path=/layout&form_action=MOVE&id="
				+ lastMenu["id"] + "&direction=" + direction + "&view=" + vView;
	}
}

function orderFolderHmvc(direction) {
	if (lastMenu["id"]) {
		callAjax("/Cms_Page/move", lastMenu["id"], direction);
	}
}

function DragnDropFolder(pid, from, to, position) {
	if (from && to) {
		document.location.href = vTransactionPath
				+ "?form_name=page&form_path=/layout&form_action=DRAG&dragFrom="
				+ from + "&dragTo=" + to;
	}
}

function ajaxDragnDropFolder(pid, from, to, order) {
	if (from && to) {
		callAjax("/index/ajaxDragnDropFolder", pid, from, to, order);
	}
}

function menu_gauche(viewid) {
	alert('xx menu_gauche');
	if (viewid) {
		document.location.href = vIndexPath + "?view=" + viewid;
	}
}

function putonline(id, status, type) {
	alert('xx putonline');
	iframe = document.getElementById("iframeRight");
	vTransactionPath = '/_/Cms_' + ucFirst(type);
	if (id) {
		iframe.src = vTransactionPath + "?form_action=" + vOnline + "&" + type
				+ "_STATUS=" + status + "&" + type + "_ID=" + id
				+ "&form_workflow=" + type + "&retour="; // +
		// escape(getIFrameDocument('iframeRight').location.href);
	}
}

function ucFirst(str) {
	if (str.length > 0) {
		return str[0].toUpperCase() + str.substring(1).toLowerCase();
	} else {
		return str;
	}
}

function content_type(uid) {
	alert('xx content_type');
	iframe = document.getElementById("iframeRight");
	if (uid) {
		iframe.src = vIndexIframePath + "?uid=" + uid + "&view=" + vView;
	}
}

function setRightTitle(text) {
	alert('xx setRightTitle');
	try {
		document.getElementById("frame_right_top").innerHTML = (text);
	} catch (e) {
	}
}

function change_lang(obj) {
	alert('xx change_lang');
	if (obj.value) {
		document.fLang.lang.value = obj.value;
		document.fLang.submit();
	}
}

function getIFrameDocument(aID) {
	alert('xx getIFrameDocument');
	return document;
}

function getElementById(obj) {
	alert('xx getElementById');
	return document.getElementById(obj);
}

// bootstrap
var buttonDef = new Object();
function showButtons() {
	if (buttonDef) {
		for (button in buttonDef) {
			if ($('#button_' + button)) {
				if (buttonDef[button] > '') {
					$('#button_' + button).css('display', 'block');
				} else {
					$('#button_' + button).css('display', 'none');
				}
			}
		}
	}
}

function inboxHeight() {
	if ($('#leftbox-content')) {
		windowHeight = $(window).height() - $.navbar_height;
		$('.widget-body').css('min-height', windowHeight + 'px');
	}
}

function selectProfile(value) {
	if (value) {
		if (document.fLogin) {
			document.fLogin.submit();
		} else {
			document.fSite.SITE_ID.value = value;
			document.fSite.submit();
		}
	}
}

function selectLanguage(value) {
	if (value) {
		document.fLang.lang.value = value;
		document.fLang.referer.value = document.location.href;
		document.fLang.submit();
	}
}

var lastMenu = new Object;
function menu(tid, tc, id, pid, reado) {
	alert('menu');
	lastMenu["tid"] = tid;
	lastMenu["tc"] = tc;
	if (id != -2) {
		lastMenu["id"] = id;
	}

	location.href = '/#/_/Index/child' + "?tid=" + tid
			+ (tc ? "&tc=" + tc : "") + (id ? "&id=" + id : "")
			+ (pid ? "&pid=" + pid : "") + (reado ? "&readO=" + reado : "");
}

function navState(tid, sid, lib) {
	if (sid) {
		url = '/_/Index/inside' + "?tid=" + tid + "&sid=" + sid
				+ "&titre_workflow=" + escape(lib);
		loadURL(url, $('#rightbox-content'))
	}
}

function nav(tid, tc, id, pid, reado) {
	url = '/_/Index/inside' + "?tid=" + tid + (tc ? "&tc=" + tc : "")
			+ (id ? "&id=" + id : "") + (pid ? "&pid=" + pid : "")
			+ (reado ? "&readO=" + reado : "");
	loadURL(url, $('#rightbox-content'))
}

function navMedia(id, pid, allowAdd, allowDel, lib) {
	showListMedia(id, pid, id, true, allowAdd, allowDel, false, lib);
}

function showListMedia(folderId, folderParentId, physpath, isFolder, allowAdd,
		allowDel, keepSearch, lib) {

	current.isFolder = isFolder;
	setFolderB(folderId, folderParentId, allowAdd, allowDel, lib);
	current.physicalPath = physpath;
	current.fileAttribut = new Object;
	if (!current.initialPath) {
		current.initialPath = current.physicalPath;
	}
	resetMedia();
	url = '/_/Index/inside' + "?tid=17&root=" + current.physicalPath + "&type="
			+ current.mediaType + "&lib=" + mediaDir + "&format="
			+ current.format + "&zone=" + current.zone
			+ (keepSearch ? "" : "&recherche=") + getTimeStamp()
			+ (current.tiny ? "&tiny=true" : ""); // PLA20130129 : suppression
	// du ; avant +
	// (keepSearch...
	loadURL(url, $('#rightbox-content'));
}

function setFolderB(id, pid, allowAdd, allowDel, lib) {
	current.node = id;
	current.parentnode = pid;
	current.allowAdd = allowAdd;
	current.allowDel = allowDel;
	current.path = lib;

	current.physicalPath = id;
	current.initialPath = id;
}

function highlightSelected(obj) {
	if (obj && current.zone == "media") {
		if (cSelected) {
			cSelected.style.backgroundColor = "";
		}
		cSelected = obj;
		cSelected.style.backgroundColor = "#C3DBF7";
	}
}

function resetMedia() {
	current.fileAttribut = new Object;
	current.mediaPath = null;
	current.mediaTag = null;
	media_previewTag = null;
	current.mediaId = null;
	current.defineProperties = false;
	refreshButtons();
}

function showMediaB(file, id) {
	if (file && current.zone != "media") {
		oldSrc = document.location.href;
	}
	var query = "";
	var page = "/_/Media/?";
	var frame = document.getElementById("properties");
	if (file) {
		query = "root=" + current.physicalPath + "&type=" + current.mediaType
				+ "&preview=" + file + "&format=" + current.format + "&id="
				+ id + "&format=" + current.format + "&zone=" + current.zone
				+ getTimeStamp();
	}
	page = "/_/Media/edit?";
	query = "action=edit&media=true&view=" + current.mediaType + "&" + query;

	url = page + query;
	loadURL(url, $('#media_right'))

}

function setFilterB(type) {
	if (type) {
		current.mediaType = type;
	}
	showListMedia(current.node, current.parentnode, current.physicalPath,
			current.isFolder, current.allowAdd, current.allowDel, true);
}

function previewMediaB(file, id, obj) {
	showMediaB(file, id);
	highlightSelected(obj);
}

function setActionB(action, type) {

	newfolder = "";
	/** Un chemin doit exister sinon on annule l'action */
	if (!current.physicalPath) {
		return false;
	} else {
		switch (type) {
		case "file": {
			/** Confirmation de la suppression du media */
			if (!((action == "del" && confirm(aLabel["POPUP_MEDIA_MSG_DEL_FILE"]))
					|| action == "add" || action == "move")) {
				return false;
			}
			if (action == "move") {
				/**
				 * Un media doit avoir été déplacé ("cut") un une
				 * destination choisie ("paste")
				 */
				if (!current.move["cut"] || !current.move["paste"]) {
					alert(aLabel["POPUP_MEDIA_MSG_SELECT_MEDIA"]);
					return false;
				}
				/** Confirmation du déplacement du dossier */
				if (!confirm(aLabel["POPUP_MEDIA_MSG_MOVE_MEDIA"])) {
					return false;
				}
				action = action + "&from=" + current.move["cut"] + "&to="
						+ current.move["paste"];
			}
			break;
		}
		case "folder": {
			newfolder = "";
			if (action == "del") {
				/** L'élément courant doit être un dossier */
				if (!current.isFolder) {
					alert(aLabel["POPUP_MEDIA_MSG_SELECT_FOLDER"]);
					return false;
				}
				/** Confirmation de la suppression du dossier */
				if (!confirm(aLabel["POPUP_MEDIA_MSG_DEL_FOLDER"])) {
					return false;
				}
			}
			if (action == "move") {
				/**
				 * Un dossier doit avoir été coupé ("cut") un une destination
				 * choisie ("paste")
				 */
				if (!current.move["cut"] || !current.move["paste"]) {
					alert(aLabel["POPUP_MEDIA_MSG_SELECT_FOLDER"]);
					return false;
				}
				/** Confirmation du déplacement du dossier */
				if (!confirm(aLabel["POPUP_MEDIA_MSG_MOVE_FOLDER"])) {
					return false;
				}
				action = action + "&from=" + current.move["cut"] + "&to="
						+ current.move["paste"];
			}
			break;
		}
		}
		var path = "";

		/*
		 * var frame = getIFrameDocument("iframeRight"); if (current.zone ==
		 * "media") { frame = getIFrameDocument("properties",
		 * getIFrameDocument("iframeRight")); }
		 */

		page = "/_/Media/edit?";
		query = "action=" + action + "&view=" + current.mediaType + "&type="
				+ type + "&root=" + current.physicalPath + "&initial="
				+ current.initialPath + "&zone=" + current.zone;
		if (current.mediaId) {
			url += "&id=" + current.mediaId;
		}
		;

		url = page + query;
		loadURL(url, $('#media_right'))

		refreshButtons();
	}
	return true;
}

var pageTabNumber;
function pageTab(docSearch, onglet) {
	var vSubmit;
	// $("#fFormContentSearch").rechercheTexte.value = "";
	if (!pageTabNumber) {
		pageTabNumber = '0';
	}
	$("#divRubrique" + pageTabNumber).css('display', 'none');
	pageTabNumber = onglet;
	$("#divRubrique" + pageTabNumber).css('display', 'block');
	if (onglet == "1") {
		$("#fFormContentSearch").attr('action', '/#/_/Index/inside');
		$("#fFormContentSearch").attr('target', '');
		$("#fFormContentSearch").submit();
	} else {
		dtreepage2.doDefault(top.initTree);
		top.initTree = true;
	}
}

var mediaTabNumber;
function mediaTab(docSearch, onglet) {
	docSearch.fFormMediaSearch.root.value = current.physicalPath;
	docSearch.fFormMediaSearch.type.value = current.mediaType;
	docSearch.fFormMediaSearch.path.value = unescape(current.path);
	docSearch.fFormMediaSearch.recherche.value = "";
	docSearch.fFormMediaSearch.lib.value = mediaDir;
	$("#mediaFolder").innerText = (current.path ? unescape(current.path)
			: "- Tout -");
	if (!mediaTabNumber) {
		mediaTabNumber = '0';
	}
	$("#divMedia" + mediaTabNumber).css('display', 'none');
	mediaTabNumber = onglet;
	$("#divMedia" + mediaTabNumber).css('display', 'block');
	if (onglet == "1") {
		// docSearch.fFormMediaSearch.submit();
	} else {
		$.globalEval($('#defaultjs', window.parent.document).html());
	}
}