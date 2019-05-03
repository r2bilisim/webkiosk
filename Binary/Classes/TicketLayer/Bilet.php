<?php
class Bilet{
		
		/*public $KioskID;
        public $ButonID;
        public $BiletTarih;
        public $BastanNumaraVer;
        public $BekleyenKisiSayisi;      
		*/
    public function GetNextTicketNumber($GrupID)
	{
			  $NextTicketNumber = 0;          
					Global $db;
					$bilet_tarih1=date("Y-m-d 00:00:00");
					$bilet_tarih2=date("Y-m-d 23:59:59");
					Global $vt_turu;
					
					switch($vt_turu) //hem Mssql hemde Mysql çalışabilsindiye Sorguyu düzenledim
					{
					case "Mssql":					
					$query1 = $db->query("SELECT top(1)
					  BILET_NO
					FROM
					  BILETLER
					WHERE
					  GRPID = '$GrupID' AND(
						SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2'
					  ) AND(OZEL_MUSTERI = 'False') AND(TRANSFER = 'False')
					ORDER BY
					  BID
					DESC
					", PDO::FETCH_ASSOC);
					break;
					case "Mysql":
					$query1 = $db->query("SELECT
					  BILET_NO
					FROM
					  BILETLER
					WHERE
					  GRPID = '$GrupID' AND(
						SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2'
					  ) AND(OZEL_MUSTERI = 'False') AND(TRANSFER = 'False')
					ORDER BY
					  BID
					DESC Limit 1
					", PDO::FETCH_ASSOC);
					break;
				}
				if ($query1->rowCount())
				{
					   foreach( $query1 as $row )
						{						   
							$NextTicketNumber = $row["BILET_NO"] + 1; //bilet tablosundaki bilet_no +1:sıradaki bilet
						}						  
				}
				else
				{
					$query = $db->query("SELECT BAS_NO,BIT_NO FROM GRUPLAR WHERE GRPID='$GrupID'")->fetch(PDO::FETCH_ASSOC);
					$NextTicketNumber=$query['BAS_NO'];
				   //$NextTicketNumber = new GrupDB($GRPID);
				   //$NextTicketNumber->BaslangicNo; //bilet yoksa ilk bilettir ve once dahil olduğu gruba bakılacak 
				}				
			  return $NextTicketNumber;
	}
		public function GetWaitingPerson($GrupID)
        {
			Global $db;
			$dtGroups = "SELECT COUNT(BID) AS BID FROM KUYRUK Where GRPID=".$GrupID."";
			$query = $db->query($dtGroups, PDO::FETCH_ASSOC);
			if ($query->rowCount())
			{
					foreach( $query as $drStructure)
					{
						return $drStructure["BID"];  
					}					
            }
            else
            {
				return "0";
            }
        }
		public function GetBeforeLunchTicket($GrpID)
        {           
			Global $OgleArasiBaslangic;			
			$bilet_tarih1=date("Y-m-d 00:00:00");
			$bilet_tarih2= date("Y-m-d ").$OgleArasiBaslangic;
        
            $ticketRequestTime = date("Y-m-d H:i:s"); 
            $query = $this->Get("GRPID=" . $GrpID . " AND SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2'",
                "Count(BID) AS BID");

            if ($query->rowCount())
			{
					foreach( $query as $drStructure)
					{						
						return $drStructure['BID'];
					}
            }
            else
            {
                return 0;
            }
        }		
		public function GetAfterLunchTicket($GrpID)
        {   
			Global $OgleArasiBitis;
			$bilet_tarih1= date("Y-m-d ").$OgleArasiBitis;
			$bilet_tarih2=date("Y-m-d 23:59:59");
            $ticketRequestTime = date("Y-m-d H:i:s"); 
            $query = $this->Get("GRPID=" . $GrpID . " AND SIS_TAR BETWEEN '$bilet_tarih1' AND '$bilet_tarih2' GROUP BY BID",
                "Count(BID) AS BID");

            if ($query->rowCount())
			{
					foreach( $query as $drStructure)
					{					
						return $drStructure['BID'];
					}
            }
            else
            {
                return 0;
            }
        }		
		protected function Get($Where,$Columns)
        {
			Global $db;
			$dtGroups = "SELECT ".$Columns." FROM BILETLER Where ". $Where." ORDER BY BID DESC";
			$query = $db->query($dtGroups, PDO::FETCH_ASSOC);

            return $query;
        }
		/* //bunlar YeniBiletOlustur.php içine alındı
		private function CheckTheLunchTicketLimit()
        {
            $bl_Return = false;
            if (grup.BiletSinirla)
            {
                if (grup.OgleArasiBaslangic > this.BiletTarih)
                {
                    if (grup.OgledenOnceMaxBiletSayisi > GetBeforeLunchTicket(grup.GRPID))
                    {
                        bl_Return = true;
                    }
                    else
                    {
                        bl_Return = false;
                    }
                }
                else if (grup.OgleArasiBitis < this.BiletTarih || grup.GrupOgleTatilinde)
                {
                    if (grup.OgledenSonraMaxBiletSayisi > GetAfterLunchTicket(grup.GRPID))
                    {
                        bl_Return = true;
                    }
                    else
                    {
                        bl_Return = false;
                    }
                }

                else
                {
                }
            }
            else
            {
                bl_Return = true;
            }
            return bl_Return;
        }
		
		
			/*
	private function CheckAvailableTicket()
        {
            $mesaj;
            if (IsActive($ButonID, $KioskID))
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.ButonPasif);
                gotMessage.ShowDialog();
                return false;
            }

            else if (bmButon.MaxBileteUlasildimi)
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.MaxBiletUlasildi);
                gotMessage.ShowDialog();
                return false;
            }

            else if (!grup.Aktif)
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.GrupPasif);
                gotMessage.ShowDialog();
                return false;
            }

            else if (!grup.GrupMesaiSaatiDisinda)
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.GrupMesaiSaatiDisinda);
                gotMessage.ShowDialog();
                return false;
            }

            else if (!HasTicketNumber())
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.SiraKalmadi);
                gotMessage.ShowDialog();
                return false;
            }

            else if (!HasGroupLunchBreak())
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.GrupOgleTatilinde);
                gotMessage.ShowDialog();
                return false;
            }

            else if (!CheckTheLunchTicketLimit())
            {
                gotMessage = new FrmMessage(FrmMessage.MessageType.SiraKalmadi);
                gotMessage.ShowDialog();
                return false;
            }

            else return true;
        }
		*/
}
?>