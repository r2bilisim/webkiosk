<?php
include("db.php");
include("Binary/Classes/TicketLayer/Grup.php");
include("Binary/Classes/TicketLayer/GrupDB.php");
include("Binary/Classes/TicketLayer/BiletDB.php");


	$nesne=new GrupDB(83);
	echo $nesne->GRPID."<br>";	
	echo $nesne->BaslangicNo."<br>";
	echo $nesne->BitisNo."<br>";
	echo $nesne->Dongu."<br>";
	echo $nesne->Aktif."<br>";
	echo $nesne->MesaiBaslangic."<br>";
	echo $nesne->MesaiBitis."<br>";
	echo $nesne->OgleArasiBaslangic."<br>";
	echo $nesne->OgleArasiBitis."<br>";
	echo $nesne->OgleTatilindeBiletVer."<br>";
	echo $nesne->BiletSinirla."<br>";
	echo $nesne->OgledenOnceMaxBiletSayisi."<br>";
	echo $nesne->OgledenSonraMaxBiletSayisi."<br>";
	echo $nesne->BeklemeSuresiTipi."<br>";
	echo $nesne->GrupOgleTatilinde."<br>";
	echo $nesne->GrupMesaiSaatiDisinda."<br>";
	
	$yeni=new BiletDB();
	$yeni->YeniBilet(0,86,678,0,2,"",0);
?>					 