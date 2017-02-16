
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" type="text/css" href="css/DirStyle.css" />
<link rel="stylesheet" type="text/css" href="css/cb.css" />
<script language="javascript" type="text/javascript" src="js/cb.js"></script>
<script language="javascript" type="text/javascript" src="js/prototype.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="David Torres DJTWFJ" />
<title>Members Directory</title>

<script type="text/javascript">
function sendRequest() {
	new Ajax.Request("dir_results.php",
					{
					method: 'post',
					parameters: 'other='+$F('other')+'&city='+$F('city')+'&tow='+$F('tow'),
					onComplete: showResponse
					});
	}
function showResponse(req){
	$('show').innerHTML= req.responseText;
	document.getElementById('other').focus();
}
function clearCrt(){
	document.getElementById('other').value='';
	document.getElementById('city').selectedIndex ='All';
	document.getElementById('tow').selectedIndex ='All';
	document.getElementById('show').innerHTML='';
	document.getElementById('other').focus();
}
function popup()
{
	window.open('helpsearch.php', '', 'width=680,height=390,scrollbars=yes,location=no');
}
function searchKeyPress(e){
	// look for window.event in case event isn't passed in
	if (window.event) { 
		e = window.event; 
	}
	if (e.keyCode == 13)                 
	{
		document.getElementById('btnsubmit').click();
	}
} 
</script>
</head>
<body onLoad="javascript:document.frmsearch.other.focus();">
<div id="PageContainer">
	<div id="MainBody">		
		<form name=frmsearch method="post" action="" onsubmit="sendRequest(); return false;">
		<!--h1>Membership Directory</h1-->
		<div class="cbb">
			<h1 style="background-color:#f1f4f9" align=center>Members Directory</h1><br />  
			<table align=center id=searchbox_noborders class=searchbox_noborders width=600px bgcolor=white cellpadding=1 cellspacing=0> 
				<tr valign=top>
					<td width=100>&nbsp;</td>
					<td>Search:</td>
					<td>
						<input type=text name="other" id="other" autocomplete="off">
						<a href="javascript:popup();" style="font-size:10px;text-decoration:none;">
							<img src="images/help_index.png" border="0"> Search Help</img>
						</a>
					</td>
				</tr>
				<tr valign=top>
					<td width=60>&nbsp;</td>
					<td >City:</td>
					<td><select name="city" id="city">Select
						<?php
						$file = fopen("data/cities.txt", "r") or exit("Unable to open file!");
						//Output a line of the file until the end is reached
						echo "<option value=All>\t\t\t";
						while(!feof($file)) {
							echo "<option>" . fgets($file). "\t\t\t";
						}
						fclose($file);
						?>			
						</select>
					</td>
				</tr>
				<tr valign=top>
					<td width=60>&nbsp;</td>
					<td width=50px>Products/Services:</td>
					<td><select name="tow" id="tow">Select	
						<?php
						$file = fopen("data/categories.txt", "r") or exit("Unable to open file!");
						//Output a line of the file until the end is reached
						echo "<option value=All>\t\t\t";
						while(!feof($file)) {
						  echo "<option>" . fgets($file) . "\t\t\t";
						}
						fclose($file);
						?>				
						</select>
					</td>		
				</tr>
				<tr>
					<td colspan=2 width=60>&nbsp;</td>
					<td><br />
						<a href="javascript:void(0);" id="1a" onClick="sendRequest(); return false;"><img border="0" id='btnsubmit' width="80" height="25" 
							src="images/SearchMO.jpg" onmouseover = 'document.getElementById("btnsubmit").src = "images/SearchMU.jpg"'
							alt="images/SearchMO.jpg" onmouseout =  'document.getElementById("btnsubmit").src = "images/SearchMO.jpg"'				
							onClick = "sendRequest();" title="Search Directory"
						/></a>
						<a href="javascript:void(0);"><img border="0" id='btnClear' width="80" height="25" 
							src="images/ClearMO.jpg" onmouseover = 'document.getElementById("btnClear").src = "images/ClearMU.jpg"'
							alt="images/ClearMO.jpg" onmouseout =  'document.getElementById("btnClear").src = "images/ClearMO.jpg"'				
							onClick = "clearCrt();" title="Clear Result"
						/></a>
					</td>
				</tr>
			</table>
		</div>
		</form>
		<p id="show"></p>	
	<div class="clear">&nbsp;</div>
	</div>
</div>
</body>
</html>
 