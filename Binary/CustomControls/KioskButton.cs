using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using QCU.Library.Classes;
using System.IO;

namespace Kiosk.Binary.CustomControls
{
    public partial class KioskButton : Button
    {

        #region Members/Propertieses
        public int ButonID { get; set; }
        public int GrupID { get; set; }
        public int GrupID2 { get; set; }
        #region Alper
        public int GrupID3 { get; set; }
        public int GrupID4 { get; set; }
        #endregion
        public bool AltButonuVar { get; set; }
        public bool AltButonmu { get; set; }
        public string ButonText { get; set; }
        public string BiletTextSatir1 { get; set; }
        public string BiletTextSatir2 { get; set; }
        public string BiletTextSatir3 { get; set; }
        public string BiletTextSatir4 { get; set; }
        public int MaximumBiletSayisi { get; set; }
        public int BiletKopyaSayisi { get; set; }
        public bool Aktif { get; set; }
        public bool RandevuButonuMu { get; set; }
        public int BaslangicBiletNo { get; set; }
        public int BaslangicBiletNo2 { get; set; }
        public int GRP1_ORAN { get; set; }
        public int GRP2_ORAN { get; set; }
        #endregion

        #region
        public int GRP3_ORAN { get; set; }
        public int GRP4_ORAN { get; set; }

        #endregion
        #region ÖMER
        public string FONT { get; set; }
        public int PUNTO { get; set; }
        #endregion
        public KioskButton()
        {
            InitializeComponent();
        }

        protected override void OnPaint(PaintEventArgs pe)
        {
            base.OnPaint(pe);
        }


    }
}
