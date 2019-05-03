using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using QCU.Classes;
using System.Data;
using QCU.Interfaces.Classes;
using System.Collections;
using QCU.Library.Classes;

namespace Kiosk.Binary.Classes.DB
{
    public class KioskAyar 
    {
        #region Members/Propertieses
        public int KioskID { get; set; }
        public string Baslik { get; set; }
        public string AltBaslik { get; set; }
        public string OgleMesaji { get; set; }
        public string SistemKapaliMesaji { get; set; }
        public string ServisKapaliMesaji { get; set; }
        public int SolButonSayisi { get; set; }
        public int SagButonSayisi { get; set; }
        public int SolPadding { get; set; }
        public int SagPadding { get; set; }
        public string Font { get; set; }
        public int Punto { get; set; }
        public bool Aktif { get; set; }
        public int Gecikme { get; set; }

        public bool HasAnyRecord;
        public int ArkaPlanRengi { get; set; }
        public int YaziRengi { get; set; }
        public byte[] Resim { get; set; }
        public int ResimYon { get; set; }
        public string ResimAd { get; set; }
        public string EskiResimAd { get; set; }
        public int BaslikHiz { get; set; }
        public int AltBaslikHiz { get; set; }
        public bool BaslikKaysin { get; set; }
        public bool AltBaslikKaysin { get; set; }
        public bool BaslikYon { get; set; }
        public bool AltBaslikYon { get; set; }
        public string ButonFont { get; set; }
        public int ButonPunto { get; set; }
        public int TagPreviewHeight { get; set; }
        public int TagPreviewWidth { get; set; }
        public int TagPreviewTimerInterval { get; set; }
        public decimal TagPreviewZoom { get; set; }
        public int TotalTag { get; set; }
        public int MaxTotalTag { get; set; }
        public int TagOverFlowPerId { get; set; }
        public string TagOverFlowMessage { get; set; }
        public string RandevuButonMetni { get; set; }
        public string BeklemeSuresiMetni { get; set; }
        public int AltButonSuresi { get; set; }
        public bool WebdenRandevu { get; set; }
        public bool BarkodlaEtiket { get; set; }
        #endregion

        #region Methods
        #region Constructer Methods
        public KioskAyar() { }
        public KioskAyar( string _KID ) {
            DataTable dtStructure = Get( "KID=" + _KID,
                "KID, BASLIK, ALT_BASLIK, MESAJ_OGLE, MESAJ_SISTEM_KAPALI, MESAJ_SERVIS_KAPALI, SOL_BTN_ADET, SAG_BTN_ADET, "
              + "SOL_PADDING, SAG_PADDING,  FONT, PUNTO, GECIKME, YAZI_RENGI, RENK, RESIM_AD, ESKI_RESIM_AD, RESIM_YON, AKTIF, "
              + "BASLIK_KAY, ALT_BASLIK_KAY, YON_BASLIK, YON_ALT_BASLIK, HIZ_BASLIK, HIZ_ALT_BASLIK, BTN_FONT, BTN_PUNTO, "
              + "TagPreviewHeight, TagPreviewWidth, TagPreviewTimerInterval, TagPreviewZoom, TotalTag, MaxTotalTag, "
              + "TagOverFlowPerId, TagOverFlowMessage, RandevuButonMetni, AltButonSuresi, WebdenRandevu, BeklemeSuresiMetni, BarkodlaEtiket");

            if( dtStructure.Rows.Count > 0 ) {
                DataRow drStructure = dtStructure.Rows[0];
                KioskID = int.Parse( drStructure["KID"].ToString() );
                Baslik = drStructure["BASLIK"].ToString();
                AltBaslik = drStructure["ALT_BASLIK"].ToString();
                OgleMesaji = drStructure["MESAJ_OGLE"].ToString();
                SistemKapaliMesaji = drStructure["MESAJ_SISTEM_KAPALI"].ToString();
                ServisKapaliMesaji = drStructure["MESAJ_SERVIS_KAPALI"].ToString();
                SolButonSayisi = int.Parse( drStructure["SOL_BTN_ADET"].ToString() );
                SagButonSayisi = int.Parse( drStructure["SAG_BTN_ADET"].ToString() );
                SolPadding = int.Parse( drStructure["SOL_PADDING"].ToString() );
                SagPadding = int.Parse( drStructure["SAG_PADDING"].ToString() );
                Font = drStructure["FONT"].ToString();
                Punto = int.Parse( drStructure["PUNTO"].ToString() );
                Gecikme = int.Parse( drStructure["GECIKME"].ToString() );
                Aktif = bool.Parse( drStructure["AKTIF"].ToString() );


                this.AltBaslikHiz = Convert.ToInt32( drStructure["HIZ_ALT_BASLIK"] );
                this.AltBaslikKaysin = Convert.ToBoolean( drStructure["ALT_BASLIK_KAY"] );
                this.AltBaslikYon = Convert.ToBoolean( drStructure["YON_ALT_BASLIK"] );

                this.BaslikHiz = Convert.ToInt32( drStructure["HIZ_BASLIK"] );
                this.BaslikKaysin = Convert.ToBoolean( drStructure["BASLIK_KAY"] );
                this.BaslikYon = Convert.ToBoolean( drStructure["YON_BASLIK"] );

                //this.ButonFont = drStructure["BTN_FONT"].ToString();
                //this.ButonPunto = Convert.ToInt32( drStructure["BTN_PUNTO"] );


                if( !string.IsNullOrEmpty( drStructure["RENK"].ToString() ) ) {
                    ArkaPlanRengi = int.Parse( drStructure["RENK"].ToString() );
                }

                if( ArkaPlanRengi == System.Drawing.Color.Transparent.ToArgb() || ArkaPlanRengi == 0 ) {
                    ArkaPlanRengi = System.Drawing.Color.FromKnownColor( System.Drawing.KnownColor.Black ).ToArgb();
                }


                if( !string.IsNullOrEmpty( drStructure["YAZI_RENGI"].ToString() ) ) {
                    YaziRengi = int.Parse( drStructure["YAZI_RENGI"].ToString() );
                }

                ResimAd = drStructure["RESIM_AD"].ToString();
                EskiResimAd = drStructure["ESKI_RESIM_AD"].ToString();

                //mt
                TagPreviewHeight = Convert.ToInt32(drStructure["TagPreviewHeight"]);
                TagPreviewWidth = Convert.ToInt32(drStructure["TagPreviewWidth"]);
                TagPreviewTimerInterval = Convert.ToInt32(drStructure["TagPreviewTimerInterval"]);
                TagPreviewZoom = Convert.ToDecimal(drStructure["TagPreviewZoom"]);
                TotalTag = Convert.ToInt32(drStructure["TotalTag"]);
                MaxTotalTag = Convert.ToInt32(drStructure["MaxTotalTag"]);
                TagOverFlowPerId = Convert.ToInt32(drStructure["TagOverFlowPerId"]);
                TagOverFlowMessage = drStructure["TagOverFlowMessage"].ToString();
                RandevuButonMetni = drStructure["RandevuButonMetni"].ToString();
                AltButonSuresi = Convert.ToInt32(drStructure["AltButonSuresi"]);
                WebdenRandevu = bool.Parse(drStructure["WebdenRandevu"].ToString());
                BeklemeSuresiMetni = drStructure["BeklemeSuresiMetni"].ToString();
                BarkodlaEtiket = bool.Parse(drStructure["BarkodlaEtiket"].ToString());

                HasAnyRecord = true;
            }
            else {
                HasAnyRecord = false;
            }
        }
        #endregion


        public byte[] GetImage( string _KioskID ) {
            DataTable dtImage = this.Get( "KID = " + _KioskID, "RESIM" );
            if (dtImage != null && dtImage.Rows.Count > 0)
            {
                return (byte[])dtImage.Rows[0][0];
            }
            else {
                return null;
            }
        }

        public void GetMessage( string _KskID ) {
            DataTable dtMsg = this.Get("KID = " + _KskID, "MESAJ_OGLE, MESAJ_SISTEM_KAPALI, MESAJ_SERVIS_KAPALI, TagOverFlowMessage");
            this.OgleMesaji = dtMsg.Rows[0]["MESAJ_OGLE"].ToString();
            this.SistemKapaliMesaji = dtMsg.Rows[0]["MESAJ_SISTEM_KAPALI"].ToString();
            this.ServisKapaliMesaji = dtMsg.Rows[0]["MESAJ_SERVIS_KAPALI"].ToString();
            this.TagOverFlowMessage = dtMsg.Rows[0]["TagOverFlowMessage"].ToString();
        }

        public bool IsAktif() {
            DataTable dtIsAktif = this.Get( "KID = " + this.KioskID, "AKTIF" );
            this.Aktif = bool.Parse( dtIsAktif.Rows[0][0].ToString() );
            return this.Aktif;
        }

        #region CRUD Process Methods
        public DataTable Get() {
            DataTable dtGetData = (DataTable)DBProcess.SimpleQuery( "KIOSK_AYAR",
                "",
                "", "*" )["DataTable"];

            return dtGetData;
        }

        public DataTable Get( string Where, string Columns ) {
            DataTable dtGet = (DataTable)DBProcess.SimpleQuery( "KIOSK_AYAR",
                            "Where " + Where,
                            "ORDER BY KID DESC",
                            Columns )["DataTable"];

            return dtGet;
        }
        #endregion



        #region Kullanilmayan metodlar
        #region   Yardimci metodlar
        #endregion

        #endregion
        #endregion
    }
}
