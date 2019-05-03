using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Data;
using System.Collections;
using QCU.Library.Classes;
using Kiosk.Binary.CustomControls;
using System.Windows.Forms;
using Kiosk.Forms;

namespace QPU_SerialPort.Classes.TicketLayer
{
    public partial class Bilet
    {
        #region Members/Properties
        public int KioskID { get; set; }
        public int ButonID { get; set; }
        public DateTime BiletTarih { get; set; }
        public bool BastanNumaraVer { get; set; }
        public string BekleyenKisiSayisi { get; set; }

        #region Common/Public Variables

        private static BiletMakineButon bmButon;
        private static Grup grup;
        public KioskButton kskBtn;

        #endregion

        public enum TicketResult
        {
            NotAvailableTicket = 0,
            AvailableTicket = 1,
            GotError = 2
        }

        #endregion

        #region Methods

        #region Bilet olusturma, kaydetme ve yazdirma metodlari

        public static void NewTicketRequest(KioskButton _kskBtn)
        {

        }

        public TicketResult Create()
        {
            if (!CheckAvailableTicket())
            {
                return TicketResult.NotAvailableTicket;
            }

            int TicketNumber = CheckAndCorrectTicketNumber();
            string WaitingPersonCount = GetWaitingPerson(GrupID);
            this.BekleyenKisiSayisi = WaitingPersonCount;
            Hashtable hshNewTicketResult;
            if (TicketNumber == 0)
            {
                return TicketResult.GotError;
            }

            this.TerminalID = 0;
            this.BiletNo = TicketNumber;
            this.AlinmaTarihi = this.BiletTarih;
            this.Transfer = false;
            this.Tur = 0;
            this.Fiktif = false;
            this.GrupOrtSureYazdirmaTipi = grup.BeklemeSuresiTipi;
            this.Zaman = Convert.ToDateTime("01.01.1900");
            this.MusteriAdi = "";
            this.MusteriNo = "";


            hshNewTicketResult = this.New();
            if (!hshNewTicketResult.ContainsKey("Error"))
            {
                Console.WriteLine(
                    "{0} numaralı bilet {1} ID'li grup için {2} adresli bilet makinesine gönderildi.",
                    this.BiletNo,
                    grup.GRPID,
                    this.KioskID
                    );

                return TicketResult.AvailableTicket;
            }
            else
            {
                return TicketResult.GotError;
            }
        }

        public TicketResult Create(string musteriNo, string musteriAdi)
        {
            if (!CheckAvailableTicket())
            {
                return TicketResult.NotAvailableTicket;
            }

            int TicketNumber = CheckAndCorrectTicketNumber();
            string WaitingPersonCount = GetWaitingPerson(GrupID);
            this.BekleyenKisiSayisi = WaitingPersonCount;
            Hashtable hshNewTicketResult;
            if (TicketNumber == 0)
            {
                return TicketResult.GotError;
            }

            this.TerminalID = 0;
            this.BiletNo = TicketNumber;
            this.AlinmaTarihi = this.BiletTarih;
            this.Transfer = false;
            this.Tur = 0;
            this.Fiktif = false;
            this.GrupOrtSureYazdirmaTipi = grup.BeklemeSuresiTipi;
            this.Zaman = Convert.ToDateTime("01.01.1900");
            this.MusteriAdi = musteriAdi;
            this.MusteriNo = musteriNo;


            hshNewTicketResult = this.New();
            if (!hshNewTicketResult.ContainsKey("Error"))
            {
                Console.WriteLine(
                    "{0} numaralı bilet {1} ID'li grup için {2} adresli bilet makinesine gönderildi.",
                    this.BiletNo,
                    grup.GRPID,
                    this.KioskID
                    );

                return TicketResult.AvailableTicket;
            }
            else
            {
                return TicketResult.GotError;
            }
        }

        public TicketResult Create(int ticketNumber, DateTime zaman)
        {
            if (!CheckAvailableTicket())
            {
                return TicketResult.NotAvailableTicket;
            }

            int TicketNumber = ticketNumber; //CheckAndCorrectTicketNumber();
            string WaitingPersonCount = GetWaitingPerson(GrupID);
            this.BekleyenKisiSayisi = WaitingPersonCount;
            Hashtable hshNewTicketResult;
            if (TicketNumber == 0)
            {
                return TicketResult.GotError;
            }

            this.TerminalID = 0;
            this.BiletNo = TicketNumber;
            this.AlinmaTarihi = this.BiletTarih;
            this.Transfer = false;
            this.Tur = 0;
            this.Fiktif = false;
            this.Zaman = zaman;

            hshNewTicketResult = this.New();
            if (!hshNewTicketResult.ContainsKey("Error"))
            {
                Console.WriteLine(
                    "{0} numaralı bilet {1} ID'li grup için {2} adresli bilet makinesine gönderildi.",
                    this.BiletNo,
                    grup.GRPID,
                    this.KioskID
                    );

                return TicketResult.AvailableTicket;
            }
            else
            {
                return TicketResult.GotError;
            }
        }

        #endregion



        #region Bilet bilgileri alma metodlari

        public string GetWaitingPerson(int GrupID)
        {
            DataTable dtWaitingPersonCount = (DataTable) DBProcess.SimpleQuery("KUYRUK",
                "Where GRPID=" + GrupID,
                "",
                "COUNT(BID) AS BID")["DataTable"];

            if (dtWaitingPersonCount != null && dtWaitingPersonCount.Rows.Count > 0)
            {
                return dtWaitingPersonCount.Rows[0][0].ToString();
            }
            else
            {
                return "0";
            }
        }

        public int GetNextTicketNumber(bool sureliMi)
        {
            //süreli mi true ise, verilemeyen biletlerden ilki gelmeli.
            int NextTicketNumber = 0;
            string strWhereSQL =
                string.Format(
                    "Where GRPID={0} AND (SIS_TAR BETWEEN '{1}' AND '{2}') AND (OZEL_MUSTERI='False') AND (TRANSFER='False') ",
                    this.GrupID,
                    BiletTarih.ToString("yyyy.MM.dd 00:00:00"),
                    BiletTarih.ToString("yyyy.MM.dd 23:59:59")
                    );

            DataTable dtTicketNumber = (DataTable) DBProcess.SimpleQuery("BILETLER",
                strWhereSQL,
                "ORDER BY BID DESC limit 1",
                "BILET_NO")["DataTable"];

            if (dtTicketNumber != null)
            {
                if (dtTicketNumber.Rows.Count > 0)
                {
                    NextTicketNumber = int.Parse(dtTicketNumber.Rows[0][0].ToString()) + 1;
                }
                else
                {
                    NextTicketNumber = grup.BaslangicNo;
                    
                }
            }
            else
            {
                NextTicketNumber = 0;
            }

            return NextTicketNumber;
        }

        #endregion



        #region Control Methods

        private bool CheckAvailableTicket()
        {
            FrmMessage gotMessage;
            if (!bmButon.IsActive(this.kskBtn.ButonID, this.KioskID))
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


        private bool HasTicketNumber()
        {
            if (grup.BitisNo >= this.BiletNo)
            {
                return true;
            }
            else
            {
                if (grup.Dongu)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        private static bool HasGroupLunchBreak()
        {
            if (!grup.GrupOgleTatilinde)
            {
                return true;
            }
            else
            {
                if (grup.OgleTatilindeBiletVer)
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
        }


        private bool CheckTheLunchTicketLimit()
        {
            bool bl_Return = false;
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


        private int GetAfterLunchTicket(int GrpID)
        {
            DataTable dtTicketCount;
            string dtmTicketTime = grup.OgleArasiBaslangic.ToString("yyyy.MM.dd hh:mm:ss");
            string strWhereSQL = string.Format("(GRPID={0}) AND (SIS_TAR >='{1}')", GrpID, dtmTicketTime);
            dtTicketCount = this.Get(strWhereSQL, "COUNT(BID) AS BID");


            if (dtTicketCount != null && dtTicketCount.Rows.Count > 0)
            {
                return int.Parse(dtTicketCount.Rows[0][0].ToString());
            }
            else
            {
                return 0;
            }
        }

        private int GetBeforeLunchTicket(int GrpID)
        {
            DataTable dtTicketCount;
            string ticketRequestTime = this.BiletTarih.ToString("yyyy.MM.dd");
            dtTicketCount = this.Get("GRPID=" + GrpID + " AND SIS_TAR ='" + ticketRequestTime + "' GROUP BY BID",
                "Count(BID)");

            if (dtTicketCount != null && dtTicketCount.Rows.Count > 0)
            {
                return int.Parse(dtTicketCount.Rows[0][0].ToString());
            }
            else
            {
                return 0;
            }
        }

        private int CheckAndCorrectTicketNumber()
        {
            if (this.BiletNo > grup.BitisNo)
            {
                this.BiletNo = grup.BaslangicNo;
            }
            return this.BiletNo;
        }

        #endregion



        public Hashtable SetTicketOnProcess(string BID)
        {
            Hashtable hshOnProcess = new Hashtable();
            hshOnProcess.Add("TID", this.TerminalID);
            hshOnProcess.Add("ISLEM_BAS_TAR", this.IslemBaslangicSaati);
            return this.Update("BID=" + BID, hshOnProcess);
        }

        #endregion
    }
}
