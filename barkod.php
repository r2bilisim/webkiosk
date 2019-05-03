<?php
	/*
		-- =============================================
		-- Author:		EKOMURCU
		-- Create date: 06.01.2019
		-- Description:	barkodlu bilet modulu
		-- Dependency: Binary/Classes/DB/BiletMakineButon.php
		-- ============================================= 
	*/	
	//Kiosk_id'ye göre tüm buton bilgilerini çek(kiosk_id'si db.php içinde tanımlıdır)
	$query = $db->query("SELECT BTNID, GRP_ID, GRP_ID2, ANA_BTNID, BTN_EKRAN, BTN_BILET_S1, BTN_BILET_S2, BTN_BILET_S3, BTN_BILET_S4,
	MAKS_BILET, BILET_KOPYA, YUKSEKLIK, GENISLIK,  AKTIF, RENK, RESIM, RESIM_AD, RESIM_YON, YAZI_RENGI, ESKI_RESIM_AD, I_YF1, I_YF2, 
	RandevuButonuMu, GRP1_ORAN, GRP2_ORAN , GRP_ID3, GRP_ID4, GRP3_ORAN, GRP4_ORAN , FONT, PUNTO, Border_Style, Border_Width, Border_Color, Border_Radius FROM BUTONLAR 
	Where BM_ADRES = '$kiosk_id'", PDO::FETCH_ASSOC);
	$biletSayac=0;
	$buton_sayisi=$query->rowCount();
	if ( $query->rowCount() ){
		foreach( $query as $row ){
			$buton_id=$row['BTNID'];
			$ana_buton_id=$row['ANA_BTNID'];
			$buton_ad=$row['BTN_EKRAN'];	
			//grup bilgilerini al
			$grupid=$row['GRP_ID'];
			$grup1Oran=$row['GRP1_ORAN'];		
			$grup_id2=$row['GRP_ID2'];
			$grup2Oran=$row['GRP2_ORAN'];
			$grup_id3=$row['GRP_ID3'];
			$grup3Oran=$row['GRP3_ORAN'];		 
			$grup_id4=$row['GRP_ID4'];	 
			$grup4Oran=$row['GRP4_ORAN'];
			
			
			#region kuyruğa bakıp en az olanı secmek için
				$query = $db->query("SELECT count(*) AS Toplam FROM KUYRUK Where GRPID=$grupid")->fetch(PDO::FETCH_ASSOC);
				$grup1KuyrukAdet= $query['Toplam'];
				$query = $db->query("SELECT count(*) AS Toplam FROM KUYRUK Where GRPID=$grup_id2")->fetch(PDO::FETCH_ASSOC);
				$grup2KuyrukAdet= $query['Toplam'];
				$query = $db->query("SELECT count(*) AS Toplam FROM KUYRUK Where GRPID=$grup_id3")->fetch(PDO::FETCH_ASSOC);
				$grup3KuyrukAdet= $query['Toplam'];
				$query = $db->query("SELECT count(*) AS Toplam FROM KUYRUK Where GRPID=$grup_id4")->fetch(PDO::FETCH_ASSOC);					 
				$grup4KuyrukAdet= $query['Toplam'];
				#region Ertu           
					$toplamKuyrukAdet = $grup1KuyrukAdet + $grup2KuyrukAdet + $grup3KuyrukAdet + $grup4KuyrukAdet;
				#endregion
				
				$toplamKuyrukAdet = ($toplamKuyrukAdet == 0 ? 1 : $toplamKuyrukAdet);
				
				$grup1KuyrukOran = 100 * $grup1KuyrukAdet / $toplamKuyrukAdet;
				$grup2KuyrukOran = 100 * $grup2KuyrukAdet / $toplamKuyrukAdet;
				$grup3KuyrukOran = 100 * $grup3KuyrukAdet / $toplamKuyrukAdet;
				$grup4KuyrukOran = 100 * $grup4KuyrukAdet / $toplamKuyrukAdet;
				#region Ertu
					
					if ($grup1Oran < $grup1KuyrukOran) 
					{
						if ($grup2Oran < $grup2KuyrukOran)
						{
							if ($grup3Oran < $grup3KuyrukOran)
							{
								if ($grup4Oran < $grup4KuyrukOran){ $grupid = $grupid; }
								else { $grupid = $grup_id4; }
							}
							else { $grupid = $grup_id3; }
						}
						else { $grupid = $grup_id2; }
					}
					else { $grupid = $grupid; }           
					
				#endregion
				
			#endregion kuyruğa bakıp en az olanı secmek için
			
			#region BUTON GÖRÜNÜM AYARLARI
				$buton_renk="#".substr(signed2hex($row['RENK']),2,6); //buton_arkaplan_rengi
				$buton_resim="data:image/jpg;charset=utf8;base64,".base64_encode($row['RESIM']); //buton_arkaplan_resmi
				$buton_resim_yon=$row['RESIM_YON'];//buton_resim_yon
				if($buton_resim_yon==1)	{ $buton_resim_yon="top left"; }
				elseif($buton_resim_yon==2){ $buton_resim_yon="top center"; }
				elseif($buton_resim_yon==4){ $buton_resim_yon="top right"; }
				elseif($buton_resim_yon==16){ $buton_resim_yon="center left"; }
				elseif($buton_resim_yon==32){ $buton_resim_yon="center center"; }
				elseif($buton_resim_yon==64){ $buton_resim_yon="center right"; }
				elseif($buton_resim_yon==256){ $buton_resim_yon="bottom left"; }
				elseif($buton_resim_yon==512){ $buton_resim_yon="bottom center"; }
				elseif($buton_resim_yon==1024){ $buton_resim_yon="bottom right"; }
				else{$buton_resim_yon="center";	}
				
				$yukseklik=$row['YUKSEKLIK']; //buton_yukseklik
				$genislik=$row['GENISLIK']; //buton_genislik
				$buton_yazi_renk="#".dechex($row['YAZI_RENGI']); //buton_yazi_rengi
				$buton_punto=$row['PUNTO']; 
				$buton_font=$row['FONT'];
				$buton_sol_hiza=$row['I_YF1'];
				$buton_ust_hiza=$row['I_YF2'];
				$aktif=$row['AKTIF'];
				$Border_Style=$row['Border_Style'];
				$Border_Width=$row['Border_Width'];
				$Border_Color="#".dechex($row['Border_Color']);
				$Border_Radius=$row['Border_Radius'];
			#endregion BUTON GÖRÜNÜM AYARLARI
			$maksimumBilet=$row['MAKS_BILET']; //Yazıcının basabileceği maks. bilet
			$biletKopyaSayisi=$row['BILET_KOPYA']; //aynı anda kaçar adet bilet verilecek
			$biletSayac++;
		}
	}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
	$(document).ready(function(){
	
		var image=""; //global canvas base64 resim kodu yer tutucu									
		$('#formBarkod').keypress(function(e) {
		
			if (e.which == 13) {
				e.preventDefault();
				$.ajax({
					type: "POST",
					url: "barkodluBilet.php",
					data: $("#formBarkod").serialize(),
					beforeSend: function() {
						$('.modal-body').html('<img src=dist/img/ajax-loader.gif>');
					},
					success: function(msg) {
						//bilet ön izleme
						$('#txtBarkod').val("");
						$('#mesaj').html(msg);						
						$("#mesaj").fadeIn(1000); 
						$("#mesaj").fadeOut(2000); 
						$('.modal-body').html(msg);	
						
						//bilet modal'ini tetikleyen buton
						$("#btn").click();	
						//bilet ön izleme
								//burası yeni
								var canvas = document.getElementById("canvas"),
								context = canvas.getContext('2d'),
								html_container = document.getElementById("biletx"),
								html = html_container.innerHTML;					
								rasterizeHTML.drawHTML(html).then(function (renderResult) {
									
									canvas.width=<?php echo $TagPreviewWidth; ?>;
									canvas.height=<?php echo $TagPreviewHeight; ?>;
									context.scale(<?php echo $TagPreviewZoom; ?>,<?php echo $TagPreviewZoom; ?>);//en boy ölçeklendir
									//canvası temizle
									context.clearRect(0,0,canvas.width,canvas.height);
									context.restore();
									//canvası temizle
									//canvası çiz
									context.drawImage(renderResult.image,0,0,canvas.width,canvas.height);
									//canvası çiz
									//canvası resmet
									image = canvas.toDataURL("image/png");
									//canvası resmet	
									$.ajax({
										//ön izleme bittiğinde bileti yazıcıya yolla
										type: "POST",
										url: "escpos/example/interface/yazdir.php",
										data: { yaziciAdi:"<?php echo $yaziciAdi;?>", biletresim: image, kopyasayisi: <?php echo $biletKopyaSayisi; ?> },
										success: function(msg2) {
											//yazma başarılı
										}										
									});																											
								});
								
						//$('.modal-print').html(msg);	
						/*bilet yazdır	
							var Copies = <?php echo $biletKopyaSayisi; ?>;
							var Count=1;
							while (Count <= Copies){
							$( "#biletx" ).print();
							Count++;
							
							}			   
						// */
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
</script>
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