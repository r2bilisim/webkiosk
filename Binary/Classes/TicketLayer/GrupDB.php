<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 01.11.2017
-- Description:	Grup_DB Sınıfı
-- ============================================= 
 */
class GrupDB extends Grup
{	
      #region  Members/Propertieses
        var $GRPID;
        var $BaslangicNo;
        var $BitisNo;
        var $Dongu;
        var $Aktif;
        var $MesaiBaslangic;
        var $MesaiBitis;
        var $OgleArasiBaslangic;
        var $OgleArasiBitis;
        var $OgleTatilindeBiletVer;
        var $BiletSinirla;
        var $OgledenOnceMaxBiletSayisi;
        var $OgledenSonraMaxBiletSayisi;
        var $BeklemeSuresiTipi;
		var $GrupOgleTatilinde;
		var $GrupMesaiSaatiDisinda;
		var $minHizmetSuresi;
        #endregion

        #region Methods

        #region Constructer Methods

        public function __construct($GrupID)
		{
					$Where="GRPID=$GrupID";
					$Columns="GRPID, BAS_NO, BIT_NO, DONGU, AKTIF, MESAI_BAS, MESAI_BIT, OGLE_BAS, OGLE_BIT, OGLEN_BILET_VER,
				BILET_SINIRLA, OO_MAX_BILET, OS_MAX_BILET, BeklemeSuresiTipi, MIN_HIZMET_SURESI";            
            						          
			$query=$this->Get($Where,$Columns); //this metod içinden metoda ulaşma
          if ( $query->rowCount() ){
					foreach( $query as $row )
					{				   							
						$this->GRPID = $row["GRPID"];
						$this->BaslangicNo = $row["BAS_NO"];
						$this->BitisNo = $row["BIT_NO"];
						$this->Dongu = $row["DONGU"];
						$this->Aktif = $row["AKTIF"];
						$this->MesaiBaslangic = $row["MESAI_BAS"];
						$this->MesaiBitis = $row["MESAI_BIT"];
						$this->OgleArasiBaslangic = $row["OGLE_BAS"];
						$this->OgleArasiBitis = $row["OGLE_BIT"];
						$this->OgleTatilindeBiletVer = $row["OGLEN_BILET_VER"];
						$this->BiletSinirla = $row["BILET_SINIRLA"];
						$this->OgledenOnceMaxBiletSayisi = $row["OO_MAX_BILET"];
						$this->OgledenSonraMaxBiletSayisi = $row["OS_MAX_BILET"];
						$this->BeklemeSuresiTipi = $row["BeklemeSuresiTipi"];
						$this->minHizmetSuresi=$row["MIN_HIZMET_SURESI"];
						$this->GrupOgleTatilinde = $this->IsGroupInLunchBreak();
						$this->GrupMesaiSaatiDisinda = $this->IsGroupOutOfWorkingHours();
				}
			}
		}
		protected function Get($Where, $Columns)
        {
			Global $db;
			$dtGroups = "SELECT ".$Columns." FROM GRUPLAR Where ". $Where." AND SIL='False' ORDER BY GRPID DESC";
			$query = $db->query($dtGroups, PDO::FETCH_ASSOC);

            return $query;
        }

}		
?>