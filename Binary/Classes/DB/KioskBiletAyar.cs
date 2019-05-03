using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Collections;
using QCU.Library.Classes;
using QCU.Interfaces.Classes;

namespace Kiosk.Binary.Classes.DB
{
    public class KioskBiletAyar
    {
        #region Members/Properties

        public int KioskID { get; set; }
        public string BiletBaslik1 { get; set; }
        public string BiletBaslik2 { get; set; }
        public string BiletBaslik3 { get; set; }
        public string BiletBaslik4 { get; set; }
        public string EtiketBekleyen { get; set; }
        public string KarsilamaMesaji1 { get; set; }
        public string KarsilamaMesaji2 { get; set; }
        public string FontBekleyen { get; set; }
        public string FontKarsilama { get; set; }
        public string FontBaslik { get; set; }
        public string FontGrup { get; set; }
        public string FontTarih { get; set; }
        public string FontBiletNo { get; set; }
        public string FontBiletNo2 { get; set; }
        public int PuntoBekleyen { get; set; }
        public int PuntoKarsilama { get; set; }
        public int PuntoBaslik { get; set; }
        public int PuntoGrup { get; set; }
        public int PuntoTarih { get; set; }
        public int PuntoBiletNo { get; set; }
        public bool YazBekleyen { get; set; }
        public bool YazKarsilama { get; set; }
        public bool YazBaslik { get; set; }
        public bool YazGrup { get; set; }
        public bool YazTarih { get; set; }
        public bool YazBiletNo { get; set; }
        

        public bool HasAnyRecord;

        public bool OrtalamaBeklemeSuresiYaz { get; set; }

        #endregion



        #region Methods

        #region Constructer Methods

        public KioskBiletAyar()
        {
        }

        public KioskBiletAyar(string _KID)
        {
            DataTable dtStructure = Get("KID=" + _KID);

            if (dtStructure.Rows.Count > 0)
            {
                DataRow drStructure = dtStructure.Rows[0];
                KioskID = int.Parse(drStructure["KID"].ToString());
                BiletBaslik1 = drStructure["BILET_BASLIK_S1"].ToString();
                BiletBaslik2 = drStructure["BILET_BASLIK_S2"].ToString();
                BiletBaslik3 = drStructure["BILET_BASLIK_S3"].ToString();
                BiletBaslik4 = drStructure["BILET_BASLIK_S4"].ToString();
                EtiketBekleyen = drStructure["ETIKET_BEKLEYEN"].ToString();
                KarsilamaMesaji1 = drStructure["ETIKET_KARSILAMA1"].ToString();
                KarsilamaMesaji2 = drStructure["ETIKET_KARSILAMA2"].ToString();
                FontBekleyen = drStructure["FONT_BEKLEYEN"].ToString();
                FontKarsilama = drStructure["FONT_KARSILAMA"].ToString();
                FontBaslik = drStructure["FONT_BASLIK"].ToString();
                FontGrup = drStructure["FONT_GRUP"].ToString();
                FontTarih = drStructure["FONT_TARIH"].ToString();
                FontBiletNo = drStructure["FONT_SIRANO"].ToString();
                FontBiletNo2 = drStructure["FONT2_SIRANO"].ToString();
                PuntoBekleyen = int.Parse(drStructure["PUNTO_BEKLEYEN"].ToString());
                PuntoKarsilama = int.Parse(drStructure["PUNTO_KARSILAMA"].ToString());
                PuntoBaslik = int.Parse(drStructure["PUNTO_BASLIK"].ToString());
                PuntoGrup = int.Parse(drStructure["PUNTO_GRUP"].ToString());
                PuntoTarih = int.Parse(drStructure["PUNTO_TARIH"].ToString());
                PuntoBiletNo = int.Parse(drStructure["PUNTO_SIRANO"].ToString());
                YazBekleyen = bool.Parse(drStructure["YAZ_BEKLEYEN"].ToString());
                YazKarsilama = bool.Parse(drStructure["YAZ_KARSILAMA"].ToString());
                YazBaslik = bool.Parse(drStructure["YAZ_BASLIK"].ToString());
                YazGrup = bool.Parse(drStructure["YAZ_GRUP"].ToString());
                YazTarih = bool.Parse(drStructure["YAZ_TARIH"].ToString());
                YazBiletNo = bool.Parse(drStructure["YAZ_SIRANO"].ToString());
                OrtalamaBeklemeSuresiYaz = bool.Parse(drStructure["OrtalamaBeklemeSuresiYaz"].ToString());
              

                HasAnyRecord = true;
            }
            else
            {
                HasAnyRecord = false;
            }
        }

        #endregion


        #region CRUD Process Methods

        public DataTable Get(string Where)
        {
            DataTable dtGet = (DataTable) DBProcess.SimpleQuery("BILET_AYAR",
                "Where " + Where,
                "ORDER BY KID DESC",
                "*")["DataTable"];

            return dtGet;
        }

        #endregion

        #endregion
    }
}