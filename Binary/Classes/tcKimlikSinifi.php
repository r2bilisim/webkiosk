<?php
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 27.10.2017
-- Description:	Tc Kimlik Doğrulama Algoritması
-- ============================================= 
 */
 class tcKimlik
    {                    
         public static function Dogrumu($tc)
        {
            $durum=false;			
            if (strlen($tc) == 11)
            {
                $tek1 = 0; $cift2 = 0; $top = 0;				
                $dizi; //9 elemanlı bir dizi(tc’nin ilk 9 hanesi)
                for ($i = 0; $i < 9; $i++)
                {
                    // tc içindeki herbir rakamı dizi elemanı olarak atar
                   $dizi[$i] = substr($tc,$i,1);				   
                }
                for ($i = 0; $i < 9; $i += 2)
                {
                    //tc deki tek sayıları toplar
                    $tek1 += $dizi[$i];
                }
                for ($i = 1; $i < 9; $i += 2)
                {
                    //tc deki çift sayıları toplar
                    $cift2 += $dizi[$i];
                }
                
                    //tc deki tüm sayıları toplar
                    $top =$tek1+$cift2;
                
                //Algoritmanın oluşturulması:
                //tek sayıların toplamının 7 katından çift sayıların çıkarılması sonucu
                //oluşan sayının birler basamağının elde edilmesi(mod1)
                $mod1 = (($tek1 * 7) - $cift2) % 10;
                //tüm rakamların toplamınına birler basamağının eklenerek tekrar
                //mod işlemiyle birler basamağının elde edilmesi
                $mod2 = ($top + $mod1) % 10;
                //ve karşımızda
                //TC kimliğin son iki hanesi
                $mod = $mod1.$mod2;
                if (substr($tc,9, 2) == $mod)
                {
                    $durum = true;
                }
                else
                {
                    $durum = false;
                }
            }
                return $durum;
        }                                                      
    }

?>