<?php
class BiletMakineButon
{
		public function CheckMaxTicketLimit($_BtnID, $_MaxTicketLimit)
        {
            try
            {
                $dtTodayTicketStart =date('Y-m-d 00:00:00');
                $dtTodayTicketFinish =date('Y-m-d 23:59:59');

                $strWhereSQL = "Select count(BID) as BID From BILETLER Where BTNID='".$_BtnID."' 
				AND (SIS_TAR BETWEEN '".$dtTodayTicketStart."' AND '".$dtTodayTicketFinish."')";
				Global $db;//bu olmazsa db ye ulaşılamaz
				$dtTodayTicketCount = $db->query($strWhereSQL)->fetch(PDO::FETCH_ASSOC);
				$dtTodayTicketCount=$dtTodayTicketCount['BID'];
			
                    if ($dtTodayTicketCount < $_MaxTicketLimit)
                    {
                        return false;
                    }
                    else
                    {
                        return true;
                    }
            }
            catch (Exception $ex)
            {
                echo $ex;
                return false;
            }
        }
		public function IsActive($_BtnID, $_KioskID)
        {
			Global $db;
			$dtIsAktif = $db->query("SELECT AKTIF FROM BUTONLAR WHERE BM_ADRES = '$_KioskID' AND BTNID = '$_BtnID'")->fetch(PDO::FETCH_ASSOC);			
            return $dtIsAktif["AKTIF"];			          
        }
}
?>