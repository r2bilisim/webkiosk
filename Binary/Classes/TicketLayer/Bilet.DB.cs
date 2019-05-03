using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Collections;
using QCU.Library.Classes;
using Kiosk.Binary.CustomControls;
using System.Data.SqlClient;

namespace QPU_SerialPort.Classes.TicketLayer
{
    public partial class Bilet
    {
        #region Members/Propertieses

        public int BiletID { get; set; }
        public int TerminalID { get; set; }
        public int GrupID { get; set; }
        //public int GrupID2 { get; set; }
        public int GrupOrtSureYazdirmaTipi { get; set; }
        public int BiletNo { get; set; }
        public DateTime AlinmaTarihi { get; set; }
        public DateTime IslemBaslangicSaati { get; set; }
        public DateTime IslemBitisSaati { get; set; }
        public bool Transfer { get; set; }
        public int Tur { get; set; }
        public bool Fiktif { get; set; }
        public DateTime Zaman { get; set; }
        public string MusteriNo { get; set; }
        public string MusteriAdi { get; set; }



        #endregion


        #region Methods

        #region Constructure Methods

        //public Bilet(int BiletId)
        //{
        //    kskBtn = _kskBtn;

        //    string KioskID = Kiosk.Properties.Settings.Default.KioskID;
        //    bmButon = new BiletMakineButon(kskBtn.ButonID.ToString(), kskBtn.MaximumBiletSayisi);

        //    this.GrupID = kskBtn.GrupID;
        //    this.KioskID = int.Parse(KioskID);
        //    this.ButonID = kskBtn.ButonID;
        //    this.BiletTarih = DateTime.Now;

        //    grup = new Grup(this.GrupID);
        //    this.BiletNo = this.GetNextTicketNumber(sureliMi);
        //}

        public Bilet(KioskButton _kskBtn, bool sureliMi)
        {
            kskBtn = _kskBtn;

            string KioskID = Kiosk.Properties.Settings.Default.KioskID;
            bmButon = new BiletMakineButon(kskBtn.ButonID.ToString(), kskBtn.MaximumBiletSayisi);

            //tam burada iki gruba da bakacaðýz ve en az hangisinde ise kuyruk ekleyeceðiz.
            int grup1Oran = kskBtn.GRP1_ORAN;
            int grup2Oran = kskBtn.GRP2_ORAN;
          
            #region Alper
            int grup3Oran = kskBtn.GRP3_ORAN;
            int grup4Oran = kskBtn.GRP4_ORAN;

            #endregion
            int grupId = -1;

            DataTable dtGet1 = (DataTable)DBProcess.SimpleQuery("KUYRUK",
            "Where GRPID=" + _kskBtn.GrupID.ToString(),
            "", "count(*) Toplam"
            )["DataTable"];

            int grup1KuyrukAdet = int.Parse(dtGet1.Rows[0]["Toplam"].ToString());

            DataTable dtGet2 = (DataTable)DBProcess.SimpleQuery("KUYRUK",
            "Where GRPID=" + _kskBtn.GrupID2.ToString(),
            "", "count(*) Toplam"
            )["DataTable"];


            int grup2KuyrukAdet = int.Parse(dtGet2.Rows[0]["Toplam"].ToString());

            #region Alper
            DataTable dtGet3 = (DataTable)DBProcess.SimpleQuery("KUYRUK",
            "Where GRPID=" + _kskBtn.GrupID3.ToString(),
            "", "count(*) Toplam"
            )["DataTable"];

            int grup3KuyrukAdet = int.Parse(dtGet3.Rows[0]["Toplam"].ToString());

            DataTable dtGet4 = (DataTable)DBProcess.SimpleQuery("KUYRUK",
            "Where GRPID=" + _kskBtn.GrupID4.ToString(),
            "", "count(*) Toplam"
            )["DataTable"];


            int grup4KuyrukAdet = int.Parse(dtGet4.Rows[0]["Toplam"].ToString());

            #endregion

            #region Alper
            //int toplamKuyrukAdet = grup1KuyrukAdet + grup2KuyrukAdet;
            int toplamKuyrukAdet = grup1KuyrukAdet + grup2KuyrukAdet + grup3KuyrukAdet + grup4KuyrukAdet;
            #endregion

            toplamKuyrukAdet = (toplamKuyrukAdet == 0 ? 1 : toplamKuyrukAdet);

            int grup1KuyrukOran = 100 * grup1KuyrukAdet / toplamKuyrukAdet;
            int grup2KuyrukOran = 100 * grup2KuyrukAdet / toplamKuyrukAdet;

            #region Alper

            int grup3KuyrukOran = 100 * grup3KuyrukAdet / toplamKuyrukAdet;
            int grup4KuyrukOran = 100 * grup4KuyrukAdet / toplamKuyrukAdet;

            #endregion

         //   grupId = grup1Oran < grup1KuyrukOran ? _kskBtn.GrupID2 : _kskBtn.GrupID;

            #region Alper
            if (grup1Oran < grup1KuyrukOran) //|| (grup3Oran < grup3KuyrukOran) || (grup4KuyrukOran < grup4KuyrukOran))
            {
                if (grup2Oran < grup2KuyrukOran) //|| (grup2KuyrukOran < grup2KuyrukOran) || (grup4KuyrukOran < grup4KuyrukOran))
                {
                    if (grup3Oran < grup3KuyrukOran) //|| (grup2KuyrukOran < grup2KuyrukOran) || (grup4KuyrukOran < grup4KuyrukOran))
                    {
                        if (grup4Oran < grup4KuyrukOran) //|| (grup2KuyrukOran < grup2KuyrukOran) || (grup4KuyrukOran < grup4KuyrukOran))
                        {
                            grupId = _kskBtn.GrupID;
                        }
                        else
                        {
                            grupId = _kskBtn.GrupID4;
                        }
                    }
                    else
                    {
                        grupId = _kskBtn.GrupID3;
                    }
                    
                }
                else
                {
                    grupId = _kskBtn.GrupID2;
                }
            }
            else
            {
                grupId = _kskBtn.GrupID;
            }
           
            #endregion

            //this.GrupID = kskBtn.GrupID; 
            this.GrupID = grupId;
            this.KioskID = int.Parse(KioskID);
            this.ButonID = kskBtn.ButonID;
            this.BiletTarih = DateTime.Now;

            grup = new Grup(this.GrupID);
            this.BiletNo = this.GetNextTicketNumber(sureliMi);
        }

        public Bilet(int grupId)
        {
            //kskBtn = _kskBtn;

            //string KioskID = Randevu.Properties.Settings.Default.KioskID;
            //bmButon = new BiletMakineButon(kskBtn.ButonID.ToString(), kskBtn.MaximumBiletSayisi);


            this.GrupID = grupId; //kskBtn.GrupID;
            //this.KioskID = int.Parse(KioskID);
            //this.ButonID = kskBtn.ButonID;
            this.BiletTarih = DateTime.Now;

            grup = new Grup(this.GrupID);
            this.BiletNo = this.GetNextTicketNumber(false);
        }

        #endregion

        #region CRUD Process Methods

        public DataTable Get(string Where, string Columns)
        {
            DataTable dtGet = (DataTable)DBProcess.SimpleQuery("BILETLER",
                "Where " + Where,
                "ORDER BY BID DESC",
                Columns)["DataTable"];

            return dtGet;
        }

        public Hashtable New()
        {
            Hashtable hshNewTicket = new Hashtable();
            hshNewTicket.Add("TID", TerminalID);
            hshNewTicket.Add("GRPID", GrupID);
            hshNewTicket.Add("BILET_NO", BiletNo);
            hshNewTicket.Add("SIS_TAR", AlinmaTarihi);
            hshNewTicket.Add("TRANSFER", Transfer);
            hshNewTicket.Add("BTNID", ButonID);
            hshNewTicket.Add("OZEL_MUSTERI", Fiktif);
            hshNewTicket.Add("Zaman", Zaman);
            hshNewTicket.Add("MusteriNo", MusteriNo);
            hshNewTicket.Add("MusteriAdi", MusteriAdi);

            Hashtable hshInsertState = DBProcess.InsertData("BILETLER", hshNewTicket);

            if (!hshInsertState.ContainsKey("Error"))
            {
                string _BiletID = hshInsertState["Identity"].ToString();
                hshInsertState.Clear();
                hshInsertState = NewQueue(_BiletID);
                if (hshInsertState.ContainsKey("Error"))
                {
                    this.NewQueue(_BiletID);
                }
            }

            return hshInsertState;
        }

        private Hashtable NewQueue(string _BiletID)
        {
            Hashtable hshNewQueue = new Hashtable();
            hshNewQueue.Add("BID", _BiletID);
            hshNewQueue.Add("GRPID", GrupID);
            hshNewQueue.Add("BILET_NO", BiletNo);
            hshNewQueue.Add("TRANSFER", Transfer);
            hshNewQueue.Add("OZEL_MUSTERI", Fiktif);
            //hshNewQueue.Add("Zaman", Zaman);

            return DBProcess.InsertData("KUYRUK", hshNewQueue);
        }

        public Hashtable Update(string Where, Hashtable UpdateColumns)
        {
            return DBProcess.UpdateData("BILETLER", "Where " + Where, UpdateColumns);
        }

        #endregion

        #endregion


        

    }
}
