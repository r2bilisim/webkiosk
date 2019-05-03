<?php /*
	-- =============================================
	-- Author:		EKOMURCU
	-- Create date: 08.11.2017
	-- Description:	index sayfası
	-- ============================================= 
*/ ?>
<?php require_once('Connections/baglantim.php');?>
<?php require_once("Binary/Classes/DB/KioskAyar.php");?>
<?php require_once("Binary/Classes/TicketLayer/Grup.php");?>
<?php require_once("Binary/Classes/TicketLayer/BiletDB.php");?>
<?php require_once("Binary/Classes/TicketLayer/GrupDB.php"); ?>
<?php require_once('Binary/Classes/DB/BiletMakineButon.php'); ?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title><?php echo "Kiosk [".$kiosk_id."]-".$baslik; ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Kiosk, Bilet, Sıramatik Sistemleri">
		<meta name="author" content="E.KÖMÜRCÜ">
		<link rel="shortcut icon" href="dist/img/ico/favicon.ico">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/bootstrap.css" rel="stylesheet">
		<link href="dist/css/style.css" rel="stylesheet">
		<script src="dist/js/jquery-1.10.2.min.js"></script>
		<!-- jquery.print.js normal web browserdan çıktı almak için kullanın -->
		<script type="text/javascript" src="dist/js/jquery.print.js"></script>
			<!--rasterizeHTML html to canvas yaparak escpos a imagedata göndermek için gerekli  -->
		<script type="text/javascript" src="dist/js/rasterizeHTML.allinone.js"></script>
		<?php if($kayitvar && $Aktif){//eğer kiosk ayarları geliyorsa kiosku yükle yoksa uyarı mesajı ver ?>
			<?php 
				#sanalKlavye yükle(kioskAyar) modulu
				(isset($SanalKlavye) && $SanalKlavye==1)? require_once("klavye/index.php"):"";  
				#sanalKlavye yükle(kioskAyar) modulu
			?>
			<?php 
				#kioks css
				require_once("custom_css.php");  
				#kioks css
			?>
		</head>
		<body>		
			<?php 
				#video modulu
				(isset($VideoOynat) && $VideoOynat==1)? require_once("VideoOynat.php"):""; 
				#video modulu
			?>			
			<?php 
				#barkodla bilet modulu
				($barkodlaEtiket==1)? require_once("barkod.php"):"";
				#barkodla bilet modulu
			?>							
			<div class="container-fluid">
				<?php if($baslik_kaysin_mi){ ?>
					<marquee id="baslik" direction="<?php echo $baslik_yon; ?>" scrollamount="<?php echo $hiz_baslik; ?>" scrolldelay="<?php echo $hiz_baslik; ?>"><?php echo $baslik; ?></marquee>
					<?php }else{?>
					<div id="baslik"><?php echo $baslik; ?></div>
				<?php } ?><?php include("buton.php"); ?>
				<?php if($alt_baslik_kaysin_mi){ ?>
					<marquee id="alt_baslik" direction="<?php echo $alt_baslik_yon; ?>" scrollamount="<?php echo $hiz_alt_baslik; ?>" scrolldelay="<?php echo $hiz_alt_baslik; ?>"><?php echo $alt_baslik; ?></marquee>
					<?php }else {?>
					<div id="alt_baslik"><?php echo $alt_baslik; ?></div>
			</div>
			<?php } ?>
			<!-- Bootstrap core JavaScript
			================================================== -->
			<!-- Placed at the end of the document so the pages load faster -->
			<script src="dist/js/bootstrap.min.js"></script>
			<?php } //kayıt var bitis
			else if(!$kayitvar){//kiosk kaydı yoksa uyarı ver?>
		</head>
		<body style="background-color:black;">		
			<div class="jumbotron alert alert-danger"><span class="glyphicon glyphicon-cog" style="font-size:1.5em;"></span> Kiosk - Uyarı [OMES]</div>
			<div class="jumbotron alert alert-info"><?php echo " Belirtilen Kiosk için ayar bunumadı! Lütfen $kiosk_id'nolu kioks kaydını kontrol ediniz."; ?></div>
			<?php }else if(!$Aktif){//kiosk aktif değilse uyarı ver?>
		</head>
		<body style="background-color:black;">
			<div class="jumbotron alert alert-danger"><span class="glyphicon glyphicon-cog" style="font-size:1.5em;"></span>Kiosk - Uyarı [OMES]</div>
			<div class="jumbotron alert alert-info"><?php echo $SistemKapaliMesaji." <br>$kiosk_id'nolu kioks şuan hizmet dışıdır."; ?></div>
		<?php }?>							
	</body>
</html>


