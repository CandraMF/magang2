tinyMCE.importPluginLanguagePack('myimage','en,sv,zh_cn,cs,fa,fr_ca,fr,de,pl,pt_br,nl,da,he,nb,hu,ru,ru_KOI8-R,ru_UTF-8,nn,es,cy,is,zh_tw,zh_tw_utf8,sk');
function TinyMCE_myimage_getInfo()
{
	return{
			longname:'My Image',
			author:'Moxiecode Systems',
			authorurl:'http://tinymce.moxiecode.com',
			infourl:'http://tinymce.moxiecode.com/tinymce/docs/plugin_myimage.html',
			version:tinyMCE.majorVersion+"."+tinyMCE.minorVersion
	};
};
function TinyMCE_myimage_getControlHTML(control_name)
{
	switch(control_name)
	{
		case "myimage":
			var cmd='tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceMyImage\');return false;';
			return '<a href="javascript:'+cmd+'" onclick="'+cmd+'" target="_self" onmousedown="return false;"><img id="{$editor_id}_myimage" src="{$pluginurl}/images/image.gif" title="Upload and Insert Image" width="20" height="20" class="mceButtonNormal" onmouseover="tinyMCE.switchClass(this,\'mceButtonOver\');" onmouseout="tinyMCE.restoreClass(this);" onmousedown="tinyMCE.restoreAndSwitchClass(this,\'mceButtonDown\');" /></a>';
	}
	return "";
}
function TinyMCE_myimage_execCommand(editor_id,element,command,user_interface,value)
{
	switch(command){
		case "mceMyImage":
		var template=new Array();
		template['file']='../../plugins/myimage/myimage.php';
		template['width']=400;
		template['height']=400;
		tinyMCE.openWindow(template,{editor_id:editor_id,inline:"yes"});
		return true;
	}
	return false;
}