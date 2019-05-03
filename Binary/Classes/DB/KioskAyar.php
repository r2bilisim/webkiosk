<?php
	/*
		-- =============================================
		-- Author:		EKOMURCU
		-- Create date: 20.10.2017
		-- Description:	Kiosk Ayar
		-- ============================================= 
	*/
	//arkaplan rengi windows için (-)negatif değerli ifade (+)pozitife çevrildi
	function signedint32($value) {
		$i = (int)$value;
		if (PHP_INT_SIZE > 4)   // e.g. php 64bit
        if($i & 0x80000000) // is negative
		return $i - 0x100000000;
		return $i;
	}
	function signed2hex($value, $reverseEndianness = false) //4bayt FF,FF,FF,FF şeklinde argb değerini elde etmek için
	{
		$packed = pack('N', $value);//veritabanından okurken bunu kullan
		$hex='';
		for ($i=0; $i < 4; $i++){
			$hex .= strtoupper( str_pad( dechex(ord($packed[$i])) , 2, '0', STR_PAD_LEFT) );
		}
		$tmp = str_split($hex, 2);
		$out = implode('', ($reverseEndianness ? array_reverse($tmp) : $tmp));
		return $out;
	}
	//kiosk_id db.php içinde tanımlıdır
	$query = $db->query("SELECT * FROM KIOSK_AYAR WHERE KID=".$kiosk_id."", PDO::FETCH_ASSOC);
	if ($query->rowCount()){
		foreach( $query as $row ){
			$kiosk=$row['KID'];		               
			$baslik=$row['BASLIK'];
			$alt_baslik=$row['ALT_BASLIK'];
			
			$OgleMesaji = $row["MESAJ_OGLE"];
			$SistemKapaliMesaji = $row["MESAJ_SISTEM_KAPALI"];
			$ServisKapaliMesaji = $row["MESAJ_SERVIS_KAPALI"];
			$SolButonSayisi = $row["SOL_BTN_ADET"];
			$SagButonSayisi =$row["SAG_BTN_ADET"];
			$SolPadding =$row["SOL_PADDING"];
			$SagPadding =$row["SAG_PADDING"];       
			$Gecikme = $row["GECIKME"];
			$Aktif=$row['AKTIF'];//kiosk aktif değilse(0) MESAJ_SISTEM_KAPALI uyarısı verir
			
			$TagPreviewHeight =  $row["TagPreviewHeight"];
			$TagPreviewWidth =  $row["TagPreviewWidth"];
			$TagPreviewTimerInterval =  $row["TagPreviewTimerInterval"];
			$TagPreviewZoom =  $row["TagPreviewZoom"];
			$TotalTag =  $row["TotalTag"];
			$MaxTotalTag =  $row["MaxTotalTag"];
			$TagOverFlowPerId =  $row["TagOverFlowPerId"];
			$TagOverFlowMessage =  $row["TagOverFlowMessage"];
			$RandevuButonMetni =  $row["RandevuButonMetni"];
			$AltButonSuresi =  $row["AltButonSuresi"];
			$WebdenRandevu =  $row["WebdenRandevu"];
			$BeklemeSuresiMetni =  $row["BeklemeSuresiMetni"]; //bilet basılırken modal başlığı 
			$BarkodlaEtiket =  $row["BarkodlaEtiket"];
			
			//arkaplan resim ve renk ayarları
			$arkaplan="data:image/jpg;charset=utf8;base64,".base64_encode($row['RESIM']);
			$renk="#".substr(signed2hex($row['RENK']),2,6);
			$yon=$row['RESIM_YON'];
			if($yon==1)	{ $yon="top left"; }
			elseif($yon==2){ $yon="top center"; }
			elseif($yon==4){ $yon="top right"; }
			elseif($yon==16){ $yon="center left"; }
			elseif($yon==32){ $yon="center center"; }
			elseif($yon==64){ $yon="center right"; }
			elseif($yon==256){ $yon="bottom left"; }
			elseif($yon==512){ $yon="bottom center"; }
			elseif($yon==1024){ $yon="bottom right"; }
			else{$yon="center";	}
			//arkaplan resim ve renk ayarları
			
			//başlık ve alt başlık ayarları
			$font=$row['FONT'];
			$punto=$row['PUNTO'];
			$yazi_renk="#".dechex($row['YAZI_RENGI']);
			if($row['YON_BASLIK']==0){	$baslik_yon="left";}elseif($row['YON_BASLIK']==1){	$baslik_yon="right";}
			if($row['YON_ALT_BASLIK']==0){	$alt_baslik_yon="left";}elseif($row['YON_ALT_BASLIK']==1){	$alt_baslik_yon="right";}		
			$hiz_baslik=$row['HIZ_BASLIK'];
			$hiz_alt_baslik=$row['HIZ_ALT_BASLIK'];
			if($row['BASLIK_KAY']==1){ $baslik_kaysin_mi=true;}else{$baslik_kaysin_mi=false; }
			if($row['ALT_BASLIK_KAY']==1){ $alt_baslik_kaysin_mi=true;}else{$alt_baslik_kaysin_mi=false; }
			//başlık ve alt başlık ayarları
			
			$barkodlaEtiket=$row['BarkodlaEtiket']; //true|false
			$SanalKlavye=$row['SanalKlavye'];		//true|false
			$VideoOynat=$row['VideoOynat'];			//true|false
			
			$kayitvar=true;//hasaynrecords
			
		}
	}
	else{
		
		$kayitvar=false;//kayıt yoksa index'te uyarı verdir(ek)
	}
?>		