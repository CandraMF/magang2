function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertMyImage(folder, file_name, title, align) {
	title = tinyMCE.getLang(title);

	if (title == null)
		title = "";
	file_name = file_name;
	// XML encode
	title = title.replace(/&/g, '&amp;');
	title = title.replace(/\"/g, '&quot;');
	title = title.replace(/</g, '&lt;');
	title = title.replace(/>/g, '&gr;');

	//var html = '<img src="' + tinyMCE.baseURL + "/plugins/emotions/images/" + file_name + '" mce_src="' + tinyMCE.baseURL + "/plugins/emotions/images/" + file_name + '" border="0" alt="' + title + '" />';
	var html = '<img src="'+ file_name + '" mce_src="' + file_name + '" align="'+ align +'" border="0" alt="' + title + '" />';
	tinyMCE.execCommand('mceInsertContent', false, html);
	tinyMCEPopup.close();
}
function tampil(folder, file){
	document.getElementById("impreview").src = folder+"/"+file;
	document.getElementById("filename").value = folder+"/"+file;
}
