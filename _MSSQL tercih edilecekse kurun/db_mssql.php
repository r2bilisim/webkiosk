<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 20.10.2017
-- Description:	Veritabanı ve ayarlar
-- ============================================= 
 */

$sunucu="EKOMURCU\\SQLEXPRESS";
$veritabani="qcu";
$kullanici="sa";
$parola="1234";
$kiosk_id=130;//hangi kiosk için çalışacak ise onun id'sini girin
date_default_timezone_set('Etc/GMT-3'); //istanbul için yerel saat ayarı 
try {

     // $db = new PDO("mysql:host=31.169.73.222:3306;dbname=veriticaret_", "avciayhan", "quest+1075");
	 $db = new PDO("sqlsrv:Server=$sunucu;Database=$veritabani", "$kullanici", "$parola");
	
	 	$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
		
		
		
} catch(PDOException $e ){
     print $e->getMessage();
}
?>