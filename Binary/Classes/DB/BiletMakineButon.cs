using System.Collections;
using System.Data;
using System.Text;
using QCU.Library.Classes;

namespace Kiosk.Binary.Classes.DB
{
    internal class BiletMakineButon
    {
        #region Members/Properties

        public int ButonID { get; set; }
        public int BiletMakineAdresi { get; set; }
        public int GrupID { get; set; }
        public int AnaButonID { get; set; }
        public string ButonText { get; set; }
        public string BiletTextSatir1 { get; set; }
        public string BiletTextSatir2 { get; set; }
        public string BiletTextSatir3 { get; set; }
        public string BiletTextSatir4 { get; set; }
        public int MaximumBiletSayisi { get; set; }
        public int BiletKopyaSayisi { get; set; }
        public bool Aktif { get; set; }
        public bool RandevuButonuMu { get; set; }

        #region ÖMER
        public string FONT { get; set; }
        public int PUNTO { get; set; }
        #endregion

        public enum ButtonType
        {
            MainButton,
            SubButton,
            All
        }

        #endregion



        #region Methods

        #region Constructer Methods

        public BiletMakineButon()
        {
        }


        #endregion


        #region CRUD Process Methods

        public DataTable Get(ButtonType btnType)
        {
            string strButtonType = string.Empty;
            string strAnaButonColumn = string.Empty;
            switch (btnType)
            {
                case ButtonType.MainButton:
                    strButtonType = " WHERE BUTONLAR.ANA_BTNID=0 ";
                    strAnaButonColumn = " ";
                    break;
                case ButtonType.SubButton:
                    strButtonType = " WHERE BUTONLAR.ANA_BTNID>0 ";
                    strAnaButonColumn = " BUTONLAR.ANA_BTNID, ";
                    break;
                case ButtonType.All:
                    strButtonType = " ";
                    strAnaButonColumn = " ";
                    break;
                default:
                    break;
            }
            StringBuilder strBldrSQL = new StringBuilder();
            strBldrSQL.Append("SELECT BUTONLAR.BTNID, BUTONLAR.BM_ADRES, BUTONLAR.GRP_ID, ");
            strBldrSQL.Append(strAnaButonColumn);
            strBldrSQL.Append(
                " BUTONLAR.BTN_EKRAN, BUTONLAR.BTN_BILET_S1, BUTONLAR.BTN_BILET_S2, BUTONLAR.BTN_BILET_S3, ");
            strBldrSQL.Append(" BUTONLAR.BTN_BILET_S4, BUTONLAR.MAKS_BILET, BUTONLAR.BILET_KOPYA, BUTONLAR.ACIKLAMA, ");
            strBldrSQL.Append(" BUTONLAR.AKTIF, RandevuButonuMu, GRUPLAR.GRUP_ISMI ,BUTONLAR.FONT,BUTONLAR.PUNTO FROM BUTONLAR");
            strBldrSQL.Append(" INNER JOIN GRUPLAR ON ");
            strBldrSQL.Append(" BUTONLAR.GRP_ID = GRUPLAR.GRPID ");
            strBldrSQL.Append(strButtonType);
            strBldrSQL.Append("ORDER BY BUTONLAR.BTNID DESC");

            return DBProcess.SelectProcess(strBldrSQL.ToString());
        }

        public DataTable Get(string Where, string Columns)
        {
            DataTable dtGetData = (DataTable) DBProcess.SimpleQuery("BUTONLAR",
                "Where " + Where,
                "", Columns)["DataTable"];


            return dtGetData;
        }

        public byte[] GetImage(string _BTNID, string _KioskID)
        {
            DataTable dtImage = this.Get("BTNID = " + _BTNID + " AND BM_ADRES = " + _KioskID, "RESIM");
            if (dtImage != null && dtImage.Rows.Count > 0)
            {
                return (byte[]) dtImage.Rows[0][0];
            }
            else
            {
                return null;
            }
        }

        public bool HasSubButton(string _BTNID, string _KioskID)
        {
            DataTable dtSub = this.Get("ANA_BTNID = " + _BTNID + " AND BM_ADRES = " + _KioskID, "BTNID");
            if (dtSub != null && dtSub.Rows.Count > 0)
            {
                return true;
            }
            else
                return false;

        }


        public DataTable GetSubButtons(string _MainButtonID, string _KioskID)
        {
            StringBuilder sbl_Columns = new StringBuilder();
            sbl_Columns.Append("BTNID, GRP_ID, GRP_ID2, ANA_BTNID, BTN_EKRAN, BTN_BILET_S1, BTN_BILET_S2, BTN_BILET_S3, ");
            sbl_Columns.Append("BTN_BILET_S4, MAKS_BILET, BILET_KOPYA, YUKSEKLIK, GENISLIK,  AKTIF, RENK, RESIM_AD, ");
            sbl_Columns.Append("RESIM_YON, YAZI_RENGI, ESKI_RESIM_AD, I_YF1, I_YF2, RandevuButonuMu, GRP1_ORAN, GRP2_ORAN ");
            #region Alper
            sbl_Columns.Append(", GRP_ID3, GRP_ID4,GRP3_ORAN, GRP4_ORAN");
            #endregion
            #region ÖMER
            sbl_Columns.Append(", FONT,PUNTO"); 
            #endregion
            DataTable dtButtons = this.Get("BM_ADRES = " + _KioskID + " AND ANA_BTNID = " + _MainButtonID,
                sbl_Columns.ToString());


            return dtButtons;
        }

        public Hashtable UpdateOnlyBMAdres(string Where, int BMAdres)
        {
            Hashtable hshTableUpdate = new Hashtable();
            hshTableUpdate.Add("BM_ADRES", BMAdres);
            return DBProcess.UpdateData("BUTONLAR", "WHERE " + Where, hshTableUpdate);
        }

        public Hashtable Delete(string Where)
        {
            return DBProcess.DeleteData("BUTONLAR", "WHERE " + Where);
        }

        #endregion


        #region   Yardimci metodlar

        public static bool HasButton(int btnID, string BMAdres)
        {
            DataTable dtHas = new DataTable();
            Hashtable hshHas = DBProcess.SimpleQuery("BUTONLAR", "Where BM_ADRES=" + BMAdres + " AND BTNID=" + btnID,
                "", "BTNID");

            if (!hshHas.ContainsKey("Error"))
            {
                dtHas = (DataTable) hshHas["DataTable"];
                if (dtHas.Rows.Count > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
        }

        public static bool HasGroup(string grupID, string BMAdres)
        {
            DataTable dtHas = new DataTable();
            Hashtable hshHas = DBProcess.SimpleQuery("BUTONLAR", "Where BM_ADRES=" + BMAdres + " AND GRP_ID=" + grupID,
                "", "BTNID");

            if (!hshHas.ContainsKey("Error"))
            {
                dtHas = (DataTable) hshHas["DataTable"];
                if (dtHas.Rows.Count > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return true;
            }
        }

        private Hashtable CreateDBObjectForSQLProcess()
        {
            Hashtable hshTableDB = new Hashtable();
            hshTableDB.Add("BTNID", ButonID);
            hshTableDB.Add("BM_ADRES", BiletMakineAdresi);
            hshTableDB.Add("GRP_ID", GrupID);
            hshTableDB.Add("ANA_BTNID", AnaButonID);
            hshTableDB.Add("BTN_EKRAN", ButonText);
            hshTableDB.Add("BTN_BILET_S1", BiletTextSatir1);
            hshTableDB.Add("BTN_BILET_S2", BiletTextSatir2);
            hshTableDB.Add("BTN_BILET_S3", BiletTextSatir3);
            hshTableDB.Add("BTN_BILET_S4", BiletTextSatir4);
            hshTableDB.Add("MAKS_BILET", MaximumBiletSayisi);
            hshTableDB.Add("BILET_KOPYA", BiletKopyaSayisi);
            hshTableDB.Add("AKTIF", Aktif);
            hshTableDB.Add("RandevuButonuMu", Aktif);
            return hshTableDB;
        }

        #endregion

        #endregion
    }
}
