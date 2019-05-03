<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 01.11.2017
-- Description:	Grup Sınıfı
-- ============================================= 
 */
class Grup
{
		protected function IsGroupInLunchBreak()
        {
            $dtTicketRequest = date('H:i:s');
            if (!($dtTicketRequest > $this->OgleArasiBaslangic && $dtTicketRequest < $this->OgleArasiBitis))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
		 protected function IsGroupOutOfWorkingHours()
        {
            $dtTicketRequest = date('H:i:s');
            if (!($dtTicketRequest > $this->MesaiBaslangic && $dtTicketRequest < $this->MesaiBitis))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
}
?>