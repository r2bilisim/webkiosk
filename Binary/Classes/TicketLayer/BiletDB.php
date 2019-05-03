<?php include("Bilet.php");?>
<?php
	class BiletDB extends Bilet{						
		function YeniBilet($Fiktif,$GRPID,$BILET_NO,$TRANSFER,$BTNID,$MusteriAdi,$TID)
		{			
			Global $db;//bu Global olmazsa db ye ulaşılamaz
			$zaman=date('Y-m-d', mktime(0,0,0,01,01,1990));
			
			$AlinmaTarihi=date("Y-m-d H:i:s");
			$stmt = $db->prepare('INSERT INTO BILETLER(OZEL_MUSTERI,GRPID,TRANSFER,BTNID,MusteriAdi,
			Zaman,TID,BILET_NO,SIS_TAR) 
			VALUES (:OZEL_MUSTERI,:GRPID,:TRANSFER,:BTNID,:MusteriAdi,:Zaman,:TID,:BILET_NO,:SIS_TAR)');
			$stmt->bindParam(':OZEL_MUSTERI', $Fiktif);
			$stmt->bindParam(':GRPID', $GRPID);
			$stmt->bindParam(':TRANSFER', $TRANSFER);
			$stmt->bindParam(':BTNID', $BTNID);
			$stmt->bindParam(':MusteriAdi', $MusteriAdi);
			$stmt->bindParam(':Zaman', $zaman);
			$stmt->bindParam(':TID', $TID);
			$stmt->bindParam(':BILET_NO', $BILET_NO);
			$stmt->bindParam(':SIS_TAR', $AlinmaTarihi);
			
			$stmt->execute();//komutu çalıştır
			
			return $BID = $db->lastInsertId();//son biletID'sini al
		}
		function YeniKuyruk($BID,$GRPID,$BILET_NO,$Fiktif,$TRANSFER)
		{	
			Global $db;//bu olmazsa db ye ulaşılamaz
			$stmt = $db->prepare("INSERT INTO KUYRUK(BID,TRANSFER,BILET_NO,OZEL_MUSTERI,GRPID) 
			VALUES(:BID,:TRANSFER,:BILET_NO,:OZEL_MUSTERI,:GRPID)");
			$stmt->bindParam(':BID', $BID);
			$stmt->bindParam(':TRANSFER', $TRANSFER);
			$stmt->bindParam(':BILET_NO', $BILET_NO);
			$stmt->bindParam(':OZEL_MUSTERI', $Fiktif);
			$stmt->bindParam(':GRPID', $GRPID); 
			
			$stmt->execute();//komutu çalıştır		
		}  
	}
?>
