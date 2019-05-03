<?php /*
	-- =============================================
	-- Author:		EKOMURCU
	-- Create date: 08.11.2017
	-- Description:	index sayfası(videolu)
	-- ============================================= 
*/ ?>
<?php include('db.php');?>
<?php include("Binary/Classes/DB/KioskAyar.php");?>
<?php include("Binary/Classes/TicketLayer/Grup.php");?>
<?php include("Binary/Classes/TicketLayer/BiletDB.php");?>
<?php include("Binary/Classes/TicketLayer/GrupDB.php");
?>
<!DOCTYPE HTML>
<html><head>
	<title><?php echo "Kiosk".$kiosk_id;?></title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kiosk Browser">
    <meta name="author" content="EKOMURCU">
	<link rel="shortcut icon" href="dist/img/ico/favicon.ico"> 
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oxygen:400,300,700">
	<!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">
	<link href="dist/css/style.css" rel="stylesheet">
	<script src="dist/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="jquery.print.js"></script>
	
	<?php if($kayitvar && $Aktif){//eğer kiosk ayarları geliyorsa kiosku yükle yoksa mesaj ver?>
		<?php if(isset($sanalKlavye) && $SanalKlavye==1){ include("klavye/index.php"); } //sanalKlavye yükle ama bunu icin nasıl bir işlem yapılmalı? ?>
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
			}
		</style>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
		<script type="text/javascript">
			$(document).ready(function(){
				$('#formBarkod').keypress(function(e) {
					
					if (e.which == 13) {
						e.preventDefault();
						$.ajax({
							type: "POST",
							url: "barkodluBilet.php",
							data: $("#formBarkod").serialize(),
							beforeSend: function() {
								//$('.modal-body').html('<img src=dist/img/ajax-loader.gif>');
							},
							success: function(msg) {
								//bilet ön izleme
								$('#txtBarkod').val("");
								//$('#mesaj').html(msg);
								
								$("#mesaj").fadeIn(1000); 
								$("#mesaj").fadeOut(2000); 
								$('.modal-body').html(msg);	
								
								//bilet modal'ini tetikleyen buton
								$("#btn").click();					
								//$('.modal-print').html(msg);	
								/*bilet yazdır	
								var Copies = <?php echo $biletKopyaSayisi; ?>;
								var Count=1;
								while (Count <= Copies){
									$( "#biletx" ).print();
									Count++;
									
								}	// */		   
								
							},							
							error:function(ma,ydin)
							{
								if (ma.status === 0) {
									alert('[jquery]Bağlantı yok, ağı doğrulayın.');
									} else if (ma.status == 404) {
									alert('[jquery]Talep edilen sayfa bulunamadı. [404]');
									} else if (ma.status == 500) {
									alert('[jquery]Dahili Sunucu Hatası [500].');
									} else if (ydin === 'parsererror') {
									alert('[jquery]İstenen JSON ayrıştırması başarısız');
									} else if (ydin === 'timeout') {
									alert('[jquery]Zaman aşımı hatası.');
									} else if (ydin === 'abort') {
									alert('[jquery]Ajax isteği reddedildi.');
									} else {
									alert('[jquery]Yakalanmamış Hata.\n' + ma.responseText);
								}
							},    		
						});
						
						
					}
					var myModal = $("#barkodBilet");
					clearTimeout(myModal.data('hideInterval'));
					myModal.data('hideInterval', setTimeout(function(){
						myModal.modal('hide');
					}, <?php echo $TagPreviewTimerInterval*1000;?>));	
				});
				
			});
			/* soket denemesi
			var socket = io.connect('http://omeskiosk:3000');
			
			socket.on('reload', function (data) {
				location.reload();
				alert("");
			});
			*/
		</script>
	</head>
	<body>
		<video id="my-video" class="video" muted loop>
			<source src="media/demo.mp4" type="video/mp4">
		</video><!-- /video -->
		<script>
			(function() {
				/**
					* Video element
					* @type {HTMLElement}
					*/
					var video = document.getElementById("my-video");
					
					/**
						* Check if video can play, and play it
						*/
						video.addEventListener( "canplay", function() {
							video.play();
						});
					})();
				</script>
				<?php 	if($barkodlaEtiket==1){ ?>
					<form id="formBarkod" method="post">
						<div id="barkod"><span>Lütfen Barkodunuzu Okutun:</span>
							<div id="wrap" style="display:inline-block;">
								<input type="text" name="txtBarkod" id="txtBarkod" maxlength="11" required > 
							</div>
							<!-- bu buton olmazsa modal tetiklenemez -->
							<button id="btn" data-toggle="modal" data-target="#barkodBilet" style="display:none"></button>
							<!-- bu buton olmazsa modal tetiklenemez -->
							<span id="mesaj" style="color:maroon;"></span>
						</div>
					</form>
				<?php } ?>
				<div class="container-fluid">
					<?php if($baslik_kaysin_mi){ ?>
						<marquee id="baslik" direction="<?php echo $baslik_yon; ?>" scrollamount="<?php echo $hiz_baslik; ?>" scrolldelay="<?php echo $hiz_baslik; ?>"><?php echo $baslik; ?></marquee>
						<?php }else{?>
						<div id="baslik"><?php echo $baslik; ?></div>
					<?php } ?>
					<?php include("buton.php"); ?>
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
				<?php }//kayıt var bitis
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
					 
		<!-- Barkod Bilet Yazdırma Modali -->
  <div class="modal fade" id="barkodBilet" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-print"></span> Lütfen Bekleyiniz..</h4>
        </div>
        <div class="modal-body" style="text-align:center;">
          <?php 
		/*
			echo "GrupID:".$grupid."<br>";
			echo "ButonID:".$buton_id."<br>";
		*/
		  ?>		 		
		  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
        </div>
      </div>      
    </div>
  </div> 
		</body>
	</html>
