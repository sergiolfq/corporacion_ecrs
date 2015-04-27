<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>View Pic</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
	function tamano() {
		var awidth = document.images["foto"].width + 10 ;
		var aheight = document.images["foto"].height + 28;
self.moveTo(0,0);
self.resizeTo(awidth,aheight);
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
  <img src="<?php echo $_GET["foto"]; ?>" id="foto" onload="tamano();"> 
</center>
</body>
</html>