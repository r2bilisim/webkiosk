<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 20.10.2017
-- Description:	Kiosk Butonları
-- ============================================= 
 */
//Kiosk_id'ye göre tüm buton bilgilerini çek(kiosk_id'si db.php içinde tanımlıdır)
include("db.php");
include("Grup.DB.php");
//include("GetNextTicketNumber.php");

Grup(83,$db);


echo $BaslangicNo;

//echo GetNextTicketNumber(83);



?>