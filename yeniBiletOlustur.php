<?php include('Connections/baglantim.php');?>
<?php include("Binary/Classes/DB/KioskAyar.php");?>
<?php include("Binary/Classes/TicketLayer/Grup.php");?>
<?php include("Binary/Classes/TicketLayer/GrupDB.php");?>
<?php include("Binary/Classes/TicketLayer/BiletDB.php");?>
<?php include('Binary/Classes/DB/KioskBiletAyar.php'); ?>
<?php include('Binary/Classes/DB/BiletMakineButon.php'); ?>
<?php  
  	/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 2019-02-27 23:19:09
-- Description:	Buton.php -> yeniBiletOlustur.php ile bilet oluşturma işlemi
-- ============================================= 
 */
  if(isset($_POST["GRPID"]) && isset($_POST["BTNID"]) && isset($_POST["maksimumBilet"]))
  {  	
		$grup=new GrupDB($_POST["GRPID"]);
		$GrupOgleTatilinde=$grup->GrupOgleTatilinde;
		$GrupMesaiSaatiDisinda=$grup->GrupMesaiSaatiDisinda;
		$OgleTatilindeBiletVer=$grup->OgleTatilindeBiletVer;
		$OgleArasiBaslangic=$grup->OgleArasiBaslangic;
		$OgleArasiBitis=$grup->OgleArasiBitis;
		$MesaiBaslangic=$grup->MesaiBaslangic;
        $MesaiBitis=$grup->MesaiBaslangic;
		$Aktif=$grup->Aktif;
		if(!$Aktif) //grup servis dışı ise
		{ 
			#grup servis dışı mesajı
			echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>$ServisKapaliMesaji</span>";
			exit(); 
		}
		
		if($GrupOgleTatilinde && !$OgleTatilindeBiletVer)//grup öğle tatilindeyse ve öğle tatilinde bilet verme kapalıysa
		{
				#grup öğle tatilinde mesajı
			echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>$OgleMesaji</span>";
			exit();
		}
		
		if(!$grup->GrupMesaiSaatiDisinda)//grup mesai dışında ise
		{
				#grup mesai dışında mesajı
			echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>Talepte bulunulan servis[#".$_POST["GRPID"]."] mesai saati dışında!</span>";
			exit();
		}
			#region Sıradaki Bilet
			$yeni=new Bilet();	
		if($grup->BiletSinirla) //bilet sınırlama varsa
		{
			if($OgleArasiBaslangic > date("H:i:s"))
			{
					if($grup->OgledenOnceMaxBiletSayisi != 0 && $grup->OgledenOnceMaxBiletSayisi < $yeni->GetBeforeLunchTicket($_POST["GRPID"]))
					{
						#OgledenOnceMaxBiletSayisi aşıldı mesajı
						echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>Öğleden önce verilebilecek bilet($grup->OgledenOnceMaxBiletSayisi adet) bitmiştir.</span>";
						exit();		
					}
			}
			else if($OgleArasiBitis < date("H:i:s"))
					if($grup->OgledenSonraMaxBiletSayisi!=0 && $grup->OgledenSonraMaxBiletSayisi < $yeni->GetAfterLunchTicket($_POST["GRPID"]))
					{
						#OgledenSonraMaxBiletSayisi aşıldı mesajı
						echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>Öğleden Sonra verilebilecek bilet($grup->OgledenSonraMaxBiletSayisi adet) bitmiştir.</span>";
						exit();		
					}
		}
		
		if($grup->Dongu)//bilet bitis değerine ulaşınca başa dönsün mü?
			{ 
			$BILET_NO=$yeni->GetNextTicketNumber($_POST["GRPID"]);
			
					if ($BILET_NO > $grup->BitisNo)
					{
						$BILET_NO = $grup->BaslangicNo;
					}					
			}
			else{
				$BILET_NO=$yeni->GetNextTicketNumber($_POST["GRPID"]);
			
					if ($BILET_NO > $grup->BitisNo)
					{
						echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>Sıra Kalmadı.[Döngü Yok]</span>";
						exit();
					} 
				}
			$biletMakButton=new BiletMakineButon();
				
			
			#endregion Sıradaki Bilet
			$Fiktif=0;
			$GRPID=$_POST["GRPID"];
			$TRANSFER=0;
			$BTNID=$_POST["BTNID"];
			$maxBilet=$_POST["maksimumBilet"];
			$MusteriAdi="";
			$TID=0;
			if($biletMakButton->CheckMaxTicketLimit($BTNID,$maxBilet))//maksimum bilet sayısına ulaşıldıysa
			{
				echo "<span style='color:red; font-size:20pt;"." font-family:Arial;'>Sıra Kalmadı.<br>[Bilet $maxBilet adet ile sınırlanmıştır.]</span>";
				exit();
			}	
			$yeni=new BiletDB(); //bilet kayıt nesnesini yarat
			$bekleyen=($yeni->GetWaitingPerson($GRPID))-1;
			#region YeniBilet Ekleme
			$BID=$yeni->YeniBilet($Fiktif,$GRPID,$BILET_NO,$TRANSFER,$BTNID,$MusteriAdi,$TID); 
			#endregion YeniBilet
			#region Kuyruk Ekleme
			$yeni->YeniKuyruk($BID,$GRPID,$BILET_NO,$Fiktif,$TRANSFER);
			#endregion Kuyruk
		
	
			#region Bilet Görünüm Ayarları
			$biletAyar=new KioskBiletAyar($kiosk_id);
			//echo "<div id='biletx' style='display:inline-block; width:$TagPreviewWidth; height:$TagPreviewHeight; '>";
			echo "<div id='biletx'>";
			echo "<div style='border:2px dotted; text-align:center;'>";
			if($biletAyar->YazBaslik)		
			{
			
				echo "<div style='font-size:$biletAyar->PuntoBaslik"."pt;"." font-family:$biletAyar->FontBaslik;' >";
				if($biletAyar->BiletBaslik1!="")
				echo "<div>$biletAyar->BiletBaslik1</div>";
				if($biletAyar->BiletBaslik2!="")
				echo "<div>$biletAyar->BiletBaslik2</div>";
				if($biletAyar->BiletBaslik3!="")
				echo "<div>$biletAyar->BiletBaslik3</div>";
				if($biletAyar->BiletBaslik4!="")
				echo "<div>$biletAyar->BiletBaslik4</div>";
				echo "</div>";
			}
			if($biletAyar->YazGrup)		
			{
				$query = $db->query("Select BTN_BILET_S1,BTN_BILET_S2,BTN_BILET_S3,BTN_BILET_S4 From BUTONLAR where BTNID = $BTNID ")->fetch(PDO::FETCH_ASSOC);				
				echo "<div style='font-size:$biletAyar->PuntoGrup"."pt;"." font-family:$biletAyar->FontGrup;' >";
				if($query['BTN_BILET_S1']!="")
				echo "<div>".$query['BTN_BILET_S1']."</div>";
				if($query['BTN_BILET_S2']!="")
				echo "<div>".$query['BTN_BILET_S2']."</div>";
				if($query['BTN_BILET_S3']!="")
				echo "<div>".$query['BTN_BILET_S3']."</div>";
				if($query['BTN_BILET_S4']!="")
				echo "<div>".$query['BTN_BILET_S4']."</div>";
				echo "</div>";
			}
			if($biletAyar->YazBiletNo)		
			{
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoBiletNo."pt; font-family:".$biletAyar->FontBiletNo.";'>".$BILET_NO."</span></div>";	
			}
			if(isset($_POST['txtBarkod']) && $_POST['txtBarkod']!="")
			{
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoBekleyen."pt; font-family:".$biletAyar->FontBekleyen.";'>".$barkod."</span></div>";	
			}
			if($biletAyar->OrtalamaBeklemeSuresiYaz)		
			{
				switch($grup->BeklemeSuresiTipi)
				{
					case 0:
					break;
					case 1://min sure * bekleyen									
					$sn = date('s', strtotime($grup->minHizmetSuresi))/60;
					$dak = date('i', strtotime($grup->minHizmetSuresi));
					$saat = date('H', strtotime($grup->minHizmetSuresi))*60;
					$beklemeSuresi = floor(($saat+$dak+$sn) * $bekleyen);					
					echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoBekleyen."pt; font-family:".$biletAyar->FontBekleyen.";'>".$BeklemeSuresiMetni.":$beklemeSuresi dk</span></div>";	
					break;
					case 2://o günkü o gruptaki bekleme süresi ortalaması
					$bilet_tarih1=date("Y-m-d 00:00:00");
					$bilet_tarih2=date("Y-m-d 23:59:59");
					//alt satır mssqle göre değiştirilmeli ertu 04.06.2018-değiştirildi sorun giderildi 26.12.2018
						switch($vt_turu)
						{
							case "Mysql":
							$query = $db->query("select coalesce(cast(Round(avg(TIMESTAMPDIFF(minute,ISLEM_BAS_TAR, ISLEM_BIT_TAR)),0) as char), '- -') as OrtalamaBeklemeSuresi  from BILETLER  WHERE GRPID = $GRPID AND TID > 0  AND (SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2')")->fetch(PDO::FETCH_ASSOC);
							break;
							case "Mssql":
							$query = $db->query("select coalesce(cast(Round(avg(DATEDIFF(minute,ISLEM_BAS_TAR, ISLEM_BIT_TAR)),0) as char), '- -') as OrtalamaBeklemeSuresi  from BILETLER  WHERE GRPID = $GRPID AND TID > 0  AND (SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2')")->fetch(PDO::FETCH_ASSOC);
							break;
						}
					$beklemeSuresi= $query['OrtalamaBeklemeSuresi'];
					echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoBekleyen."pt; font-family:".$biletAyar->FontBekleyen.";'>".$BeklemeSuresiMetni.":$beklemeSuresi dk</span></div>";	
					break;
				}				
			}
			if($biletAyar->YazGrup)		
			{
				echo "<div style='text-align:center;'>Servis:<span style='font-size:".$biletAyar->PuntoGrup."pt; font-family:".$biletAyar->FontGrup.";'>".$GRPID."</span></div>";	
			}
			if($biletAyar->YazTarih)		
			{
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoTarih."pt; font-family:".$biletAyar->FontTarih.";'>".date("d.m.Y H:i:s")."</span></div>";	 
			}
			if($biletAyar->YazBekleyen)		
			{						
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoBekleyen."pt; font-family:".$biletAyar->FontBekleyen.";'>".$biletAyar->EtiketBekleyen.":".$bekleyen."</span></div>";	 
			}
			if($biletAyar->YazKarsilama)		
			{
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoKarsilama."pt; font-family:".$biletAyar->FontKarsilama.";'>".$biletAyar->KarsilamaMesaji1."</span></div>";	 
				echo "<div style='text-align:center;'><span style='font-size:".$biletAyar->PuntoKarsilama."pt; font-family:".$biletAyar->FontKarsilama.";'>".$biletAyar->KarsilamaMesaji2."</span></div>";	 
			}
			echo "</div>";
			echo "</div>";
			#endregion Bilet Görünüm Ayarları
		
		
  }
  else
  {
		echo "Yeni Bilet Verilemedi. [GrupID veya BTNID eksik]";
  }
//include("escpos/example/interface/as.php");

?>