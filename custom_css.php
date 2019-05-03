<?php
	/*
		-- =============================================
		-- Author:		EKOMURCU
		-- Create date: 06.01.2019
		-- Description:	barkodlu bilet modulu
		-- Dependency: index.php
		-- ============================================= 
	*/	
?>
<style type="text/css">
body{
	margin:0px;
	padding:0px;
	background-color:<?php echo $renk;?>;
	background-image:url('<?php echo $arkaplan; ?>');
	background-repeat: no-repeat;
	background-position: <?php echo $yon; ?>;
	background-attachment: fixed;
	
}
#baslik{
	text-align:center;
	position: fixed;
	top:10px;
	width:100%;
	font-family:<?php echo $font; ?>;
	font-size:<?php echo $punto; ?>pt;
	color:<?php echo $yazi_renk; ?>;
}
#alt_baslik{
	text-align:center;
	position: fixed;
	width:100%;
	bottom: 10px;	
	font-family:<?php echo $font; ?>;
	font-size:<?php echo $punto; ?>pt;
	color:<?php echo $yazi_renk; ?>;
	
}
button span {
  cursor: target;
  display: inline-block;
  position: relative;
  transition: 0.5s;
  z-index:9;
}

button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

button:hover span {
  padding-right: 25px;
}

button:hover span:after {
  opacity: 1;
  right: 0;
}
button:hover
{
	 box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}
#barkod{
	position: fixed;
	font-family:Arial;
	font-size:20pt;
	font-weight:bold;
	z-index:5;
	background-color:<?php echo $renk; ?>;
	color:<?php echo $yazi_renk; ?>;	
}
</style>