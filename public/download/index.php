<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facebook Like Extract URL data Using jQuery PHP and Ajax::Demo::Shubham Tips Tricks</title>

<link rel="stylesheet" href="css.css" type="text/css">
<script type="text/javascript" src="jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="jquery.livequery.js"></script>
<script type="text/javascript" src="jquery.watermarkinput.js"></script>
<style>
body{ font-family:Verdana, Arial, Helvetica, sans-serif}
#heading
{
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:56px;
	color:#CC0000;				
}

.wrap{  margin-top:20px; height:500px;}

.box{border:1px solid #E8E8E8; width:500px; padding:4px 4px 9px 4px; }

.head{ 
	background:url(link.gif) center left no-repeat; 
	padding-left:20px;
	color:#666666;
	font-weight:bold; 
	font-size:11px; 
	height:17px;
	padding-top:2px;
	width:250px;
	float:left
}
.close{ float:left; width:230px;  height:21px;}

.closes:hover{ background:url(closeh.png) center right no-repeat; height:21px;}

.closes{ background:url(close.png) top right no-repeat; width:24px; height:21px; cursor:pointer;}

cursor:pointer;
font-size:13px;
font-weight:bold;

input{ float:left;}
#url{
	font-size:13px;
	border:solid #339999 1px;
	height:20px;
	margin-left:7px;
	margin-right:0px;	
	overflow:hidden;
}
#attach{
	font-size:13px;
	font-weight:bold;
	border:solid #339999 1px;
	height:24px;
	margin-left:0px;
	overflow:hidden;
	cursor:pointer;
	padding-bottom:2px;
}
.images{width:100px; height:100px; float:left; margin-right:8px;}

.info{ width:360px; height:200px; float:left;}
#loader{ margin:16px 7px 7px 7px;}

.title{ font-size:11px; font-weight:bold; cursor:pointer; }

.url{ font-size:11px; padding:3px;}
.desc{ font-size:12px; margin-top:5px; cursor:pointer; }

.title:hover{ background-color:#FFFF99}

.desc:hover{ background-color:#FFFF99}

#prev{cursor:pointer;}
#next{cursor:pointer;}

.totalimg{ font-size:10px; color:#333333;float:left; margin:5px;}


</style>
<script type="text/javascript">
// <![CDATA[	
$(document).ready(function(){	
 
// delete event
$('#attach').livequery("click", function(){
 
	if(!isValidURL($('#url').val()))
	{
		alert('Please enter a valid url.');
		return false;
	}
	else
	{
		$('#load').show();
		$.post("fetch.php?url="+$('#url').val(), {
		}, function(response){
			$('#loader').html($(response).fadeIn('slow'));
			$('.images img').hide();
			$('#load').hide();
			$('img#1').fadeIn();
			$('#cur_image').val(1);
		});
	}
});	
// next image
$('#next').livequery("click", function(){
 
	var firstimage = $('#cur_image').val();
	$('#cur_image').val(1);
	$('img#'+firstimage).hide();
	if(firstimage <= $('#total_images').val())
	{
		firstimage = parseInt(firstimage)+parseInt(1);
		$('#cur_image').val(firstimage);
		$('img#'+firstimage).show();
	}
});	
// prev image
$('#prev').livequery("click", function(){
 
	var firstimage = $('#cur_image').val();
 
	$('img#'+firstimage).hide();
	if(firstimage>0)
	{
		firstimage = parseInt(firstimage)-parseInt(1);
		$('#cur_image').val(firstimage);
		$('img#'+firstimage).show();
	}
 
});	
// watermark input fields
jQuery(function($){
 
   $("#url").Watermark("http://");
});
jQuery(function($){
 
	$("#url").Watermark("watermark","#369");
 
});	
function UseData(){
   $.Watermark.HideAll();
   $.Watermark.ShowAll();
}
});	
function isValidURL(url){
var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

if(RegExp.test(url)){
	return true;
}else{
	return false;
}
}
// ]]>
</script>
</head>
<body>
<div style="font-size:30px;">Facebook Like Extract URL data Using jQuery PHP and Ajax</div>
<br clear="all" />
<a style="color:#000000; font-size:14px" href="http://shubhamtipstricks.com/facebook-like-url-data-extract-using-jquery-php-and-ajax/">Back To Tutorial</a>
<br clear="all" />
<input type="hidden" name="cur_image" id="cur_image" />
<div class="wrap" align="center">
 
	<div class="box" align="left">
 
		<div class="head">Link</div>
		<div class="close" align="right">
			<div class="closes"></div>
		</div>
 
		<br clear="all" /><br clear="all" />
 
		<input type="text" name="url" size="64" id="url" />
		<input type="button" name="attach" value="Attach" id="attach" />
		<br clear="all" />
 
		<div id="loader">
 
			<div align="center" id="load" style="display:none"><img src="load.gif" /></div>
 
		</div>
		<br clear="all" />
	</div>
 
</div>
</body>
</html>