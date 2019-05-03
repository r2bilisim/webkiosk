<?php
class KioskBiletAyar
    {
        #region Members/Properties      
        public $BiletBaslik1;
        public $BiletBaslik2;
        public $BiletBaslik3;
        public $BiletBaslik4;
        public $EtiketBekleyen;
        public $KarsilamaMesaji1;
        public $KarsilamaMesaji2;
        public $FontBekleyen;
        public $FontKarsilama;
        public $FontBaslik;
        public $FontGrup;
        public $FontTarih;
        public $FontBiletNo;
        public $FontBiletNo2;
        public $PuntoBekleyen;
        public $PuntoKarsilama; 
        public $PuntoBaslik;
        public $PuntoGrup;
        public $PuntoTarih;
        public $PuntoBiletNo;
        public $YazBekleyen;
        public $YazKarsilama;
        public $YazBaslik;
        public $YazGrup;
        public $YazTarih;
        public $YazBiletNo;
        public $OrtalamaBeklemeSuresiYaz;
        public $HasAnyRecord;       
        #endregion

        #region Methods      
        #region Kurucu      
        public function __construct($_KID)
        {
            $Where="KID=".$_KID;
			$Columns="*";
			$query=$this->Get($Where,$Columns);
			
            if ($query->rowCount())
			{
					foreach( $query as $drStructure)
					{				   		                                
						$this->BiletBaslik1 = $drStructure["BILET_BASLIK_S1"];
						$this->BiletBaslik2 = $drStructure["BILET_BASLIK_S2"];
						$this->BiletBaslik3 = $drStructure["BILET_BASLIK_S3"];
						$this->BiletBaslik4 = $drStructure["BILET_BASLIK_S4"];
						$this->EtiketBekleyen = $drStructure["ETIKET_BEKLEYEN"];
						$this->KarsilamaMesaji1 = $drStructure["ETIKET_KARSILAMA1"];
						$this->KarsilamaMesaji2 = $drStructure["ETIKET_KARSILAMA2"];
						$this->FontBekleyen = $drStructure["FONT_BEKLEYEN"];
						$this->FontKarsilama = $drStructure["FONT_KARSILAMA"];
						$this->FontBaslik = $drStructure["FONT_BASLIK"];
						$this->FontGrup = $drStructure["FONT_GRUP"];
						$this->FontTarih = $drStructure["FONT_TARIH"];
						$this->FontBiletNo = $drStructure["FONT_SIRANO"];
						$this->FontBiletNo2 = $drStructure["FONT2_SIRANO"];
						$this->PuntoBekleyen = $drStructure["PUNTO_BEKLEYEN"];
						$this->PuntoKarsilama = $drStructure["PUNTO_KARSILAMA"];
						$this->PuntoBaslik = $drStructure["PUNTO_BASLIK"];
						$this->PuntoGrup = $drStructure["PUNTO_GRUP"];
						$this->PuntoTarih = $drStructure["PUNTO_TARIH"];
						$this->PuntoBiletNo = $drStructure["PUNTO_SIRANO"];
						$this->YazBekleyen = $drStructure["YAZ_BEKLEYEN"];
						$this->YazKarsilama = $drStructure["YAZ_KARSILAMA"];
						$this->YazBaslik = $drStructure["YAZ_BASLIK"];
						$this->YazGrup = $drStructure["YAZ_GRUP"];
						$this->YazTarih = $drStructure["YAZ_TARIH"];
						$this->YazBiletNo = $drStructure["YAZ_SIRANO"];
						$this->OrtalamaBeklemeSuresiYaz = $drStructure["OrtalamaBeklemeSuresiYaz"];
					}

                $this->HasAnyRecord = true;
            }
            else
            {
                $this->HasAnyRecord = false;
            }
        }
        #endregion

        #region CRUD Process Methods
		protected function Get($Where, $Columns)
        {
			Global $db;
			$dtTickets = "SELECT ".$Columns." FROM BILET_AYAR Where ". $Where." ORDER BY KID DESC";
			$query = $db->query($dtTickets, PDO::FETCH_ASSOC);

            return $query;
        }      
}
?>