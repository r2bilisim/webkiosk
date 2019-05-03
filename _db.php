<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 20.10.2017
-- Description:	Veritabanı ve ayarlar
-- ============================================= 
 */
$vt_turu="Mysql"; //Mssql veya Mysql seçebilirsiniz.
$sunucu="localhost"; //Mssql için localhost veya EKOMURCU\SQLEXPRESS
$veritabani="QCU_DEMO2"; //sunucuda QCU
$kullanici="root";
$parola="nichtwar";
$kiosk_id=2;//hangi kiosk için çalışacak ise onun id'sini girin
$yaziciAdi="XP-80C"; //varsayılan yazıcı adını giriniz.
date_default_timezone_set('Etc/GMT-3'); //istanbul için yerel saat ayarı 
try {

    switch($vt_turu)
	{
		case "Mysql":
		$db = new PDO("mysql:host=$sunucu;charset=utf8;dbname=$veritabani", "$kullanici", "$parola");
		break;
		case "Mssql": //Sqlserver için pdo extension yüklü olmalı!
		$db = new PDO("sqlsrv:Server=$sunucu;Database=$veritabani", "$kullanici", "$parola");		
		break;
		default:
		echo "Veri tabanı için bir tür seçin(Mysql veya Mssql)";
		break;	 
	}				
} catch(PDOException $e ){
     print $e->getMessage();
}
?>