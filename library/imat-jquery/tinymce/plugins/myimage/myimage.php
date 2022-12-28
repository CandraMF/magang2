<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Upload and Insert Image</title>
	<script language="javascript" type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="fungsi.js"></script>
	<base target="_self" />
</head>
<body style="display: none">
	<div align="center">
		<div class="title">Upload Image:<br /><br /></div>
		<?
			
			if($HTTP_POST_VARS){foreach($HTTP_POST_VARS as $key => $value){$$key=$value;}}
			if($HTTP_GET_VARS){foreach($HTTP_GET_VARS as $key => $value){$$key=$value;}}
			if($HTTP_SESSION_VARS){foreach($HTTP_SESSION_VARS as $key => $value){$$key=$value;}}
			if($HTTP_COOKIE_VARS){foreach($HTTP_COOKIE_VARS as $key => $value){$$key=$value;}}

			if ($_GET){foreach($_GET as $key => $value){$$key = $value;}}
			if ($_POST){foreach($_POST as $key => $value){$$key = $value;}}
			if ($_SESSION){foreach($_SESSION as $key => $value){$$key = $value;}}
			if ($_COOKIE){foreach($_COOKIE as $key => $value){$$key = $value;}}

			//include "../../../../config.inc.php";
			$dir = "../../../../images/evaluasi"; // Directory untuk menyimpan image
			if(!$PHP_SELF){import_request_variables("gP");}
			$PHP_SELF = isset($PHP_SELF)?$PHP_SELF:$_SERVER['PHP_SELF'];
			$FolderName = explode("/js", dirname($PHP_SELF));
			$FolderName = $FolderName[0];
			$SITE   = "http://".$_SERVER['HTTP_HOST'].$FolderName;

			$url = "$SITE/images/evaluasi"; // url untuk menyimpan image

			$Path = realpath($dir);
			$prev = "";
			$filename = "";
			$arPath = explode("\\", $Path);
			$upload = isset($upload)?$upload:"";
			$view = isset($view)?$view:"list";
			if (!empty($upload)){
				$Filename = $_FILES['fileupload'];
				$File = &$Filename;
				if (@is_uploaded_file($File['tmp_name'])) 
				{
					@move_uploaded_file($File['tmp_name'], "$Path/".date("dmYGis")."_{$File['name']}");

					$prev = "<img src='../../../../images/evaluasi/".date("dmYGis")."_{$File['name']}' id='impreview'>";
					$filename = $url."/".date("dmYGis")."_{$File['name']}";

				}
				else
				{
					echo "Error, Filename is Empty...";
				}
			}
			$FileList = "";
			if ($getdir = @opendir($dir)) 
			{
				while ($file = readdir($getdir)) 
				{
					$type = strtolower(substr($file, strlen($file)-3, strlen($file)));
					$type2 = strtolower(substr($file, strlen($file)-4, strlen($file)));
					if ($type2 == "jpeg" || $type == "jpg" || $type == "gif" || $type == "png" || $type == "bmp" || $type2 == "tiff")
					{
						if ($view == "list")
						{
							$FileList .= "<A HREF=\"javascript:tampil('$url', '$file');\">$file</A><BR>";
						}
						else
						{
							$FileList .= "<A HREF=\"javascript:tampil('$url', '$file');\">
							<img src='$dir/$file' height='30' border='0'>
							</A><BR>";
						}
					}
				}
			}

			$prev = !empty($prev)?$prev:"<img src='images/sample.gif' id='impreview'>";
			echo "
			<FORM METHOD=POST  enctype='multipart/form-data'>
				<TABLE width='100%'>
			<TR>
				<TD><B><A HREF='?view=list'>File List</A> / <A HREF='?view=view'>File View</A></B></TD>
				<TD><B>Preview</B></TD>
			</TR>
			<TR>
				<TD>
					<div style='width:175px;height:175px;overflow-y:auto;overflow-x:hidden;border:1px solid gray'>
						$FileList
					</div>
				</TD>
				<TD>
					<div style='width:175px;height:175px;overflow:hidden;border:1px solid gray' id='preview'>
						$prev
					</div>
				</TD>
			</TR>
			</TABLE><BR>
			<TABLE width='100%'>
			<TR>
				<TD>File Upload</TD>
				<TD>: <input type='file' name='fileupload' id='fileuplaod' size='40'></TD>
			</TR>
			<TR>
				<TD>File Location</TD>
				<TD>: <input type='text' name='filename' id='filename' size='40' value='$filename'></TD>
			</TR>
			<TR>
				<TD>Description</TD>
				<TD>: <input type='text' name='desc' id='desc' size='40'></TD>
			</TR>
			<TR>
				<TD>Align</TD>
				<TD>: 
					<select name='talign' id='talign'><option value='left'>Left<option value='right'>Right<option value='center'>Center</select>
				</TD>
			</TR>
			<TR>
				<TD colspan='2'>
					<input type='button' value='Insert' onclick=\"insertMyImage('', filename.value, desc.value, talign.options[talign.selectedIndex].value)\">
					<input type='submit' name='upload' value='Upload'>
					<input type='button' value='Cancel' onclick=\"window.close()\">
				</TD>
			</TR>
			</TABLE>	
			</FORM>		
			"
		?>
	</div>
</body>
</html>
