using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Collections;
using QCU.Library.Classes;
using System.Windows.Forms;

namespace QPU_SerialPort.Classes.TicketLayer
{
    public partial class BiletMakineButon
    {
        #region Members/Propertieses

        public bool MaxBileteUlasildimi { get; set; }

        #endregion


        #region Methods

        #region Constructer Methods

        public BiletMakineButon(string _BTNID, int _MaxTicketLimit)
        {
            MaxBileteUlasildimi = CheckMaxTicketLimit(_BTNID, _MaxTicketLimit);
        }

        #endregion



        #region Logical Process and Methods

        private bool CheckMaxTicketLimit(string _BtnID, int _MaxTicketLimit)
        {
            try
            {
                string dtTodayTicket = DateTime.Now.ToShortDateString();
                dtTodayTicket = DateTime.Parse(dtTodayTicket).ToString("yyyy.MM.dd");
                string dtTodayTicketStart = string.Format("{0} 00:00:00", dtTodayTicket);
                string dtTodayTicketFinish = string.Format("{0} 23:59:59", dtTodayTicket);

                string strWhereSQL = string.Format(
                    "Where (BTNID={0}) AND (SIS_TAR BETWEEN '{1}' AND '{2}')",
                    _BtnID,
                    dtTodayTicketStart,
                    dtTodayTicketFinish
                    );

                DataTable dtTodayTicketCount = (DataTable) DBProcess.SimpleQuery(
                    "BILETLER",
                    strWhereSQL,
                    "",
                    "COUNT(BID)"
                    )["DataTable"];

                if (dtTodayTicketCount != null && dtTodayTicketCount.Rows.Count > 0)
                {
                    if (int.Parse(dtTodayTicketCount.Rows[0][0].ToString()) < _MaxTicketLimit)
                    {
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                }
                else
                {
                    return true;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.ToString());
                return false;
            }
        }

        public bool IsActive(int _BtnID, int _KioskID)
        {
            DataTable dtIsAktif = (DataTable) DBProcess.SimpleQuery(
                "BUTONLAR",
                " WHERE BM_ADRES = " + _KioskID + " AND BTNID = " + _BtnID,
                "",
                "AKTIF")["DataTable"];

            return bool.Parse(dtIsAktif.Rows[0][0].ToString());
        }

        #endregion

        #endregion
    }
}
