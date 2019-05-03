using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
/*
-- =============================================
-- Author:		EKOMURCU
-- Create date: 27.10.2017
-- Description:	Tc Kimlik Doğrulama Algoritması
-- ============================================= 
 */
namespace Kiosk.Binary.Classes
{
    class tcKimlikDogrula
    {                    
         public static bool tcDogrumu(string tc)
        {
            bool durum=false;
            if (tc.Length == 11)
            {
                int tek1 = 0, cift2 = 0, top = 0;
                string[] dizi = new string[9]; //9 elemanlı bir dizi(tc’nin ilk 9 hanesi)
                for (int i = 0; i < 9; i++)
                {
                    // tc içindeki herbir rakamı dizi elemanı olarak atar
                    dizi[i] = tc.Substring(i, 1);
                }
                for (int i = 0; i < 9; i += 2)
                {
                    //tc deki tek sayıları toplar
                    tek1 += Convert.ToInt32(dizi[i]);
                }

                for (int i = 1; i < 9; i += 2)
                {
                    //tc deki çift sayıları toplar
                    cift2 += Convert.ToInt32(dizi[i]);
                }
                for (int i = 0; i < 9; i++)
                {
                    //tc deki tüm sayıları toplar
                    top += Convert.ToInt32(dizi[i]);
                }
                //Algoritmanın oluşturulması:
                //tek sayıların toplamının 7 katından çift sayıların çıkarılması sonucu
                //oluşan sayının birler basamağının elde edilmesi(mod1)
                int mod1 = ((tek1 * 7) - cift2) % 10;
                //tüm rakamların toplamınına birler basamağının eklenerek tekrar
                //mod işlemiyle birler basamağının elde edilmesi
                int mod2 = (top + mod1) % 10;
                //ve karşımızda
                //TC kimliğin son iki hanesi
                string mod = mod1 + "" + mod2;
                if (tc.Substring(9, 2) == mod)
                {
                    durum = true;
                }
                else
                {
                    durum = false;
                }
            }
                return durum;
        }                                                      
    }
}
