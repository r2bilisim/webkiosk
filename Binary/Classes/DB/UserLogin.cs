using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using QCU.Library.Classes;

namespace QCU.Classes
{
    class UserLogin
    {
        private string Username { get; set; }
        private string Pass { get; set; }


        public UserLogin(string p_UserName, string p_Pass) {
            Username = p_UserName;
            Pass = p_Pass;
        }


        public bool Login() {
            
            DataTable dtUserInf = (DataTable)DBProcess.SimpleQuery(
                    "PERSONELLER",
                    "WHERE KULLANICI_ADI='" + Username + "' AND SIFRE='" + Pass + "'",
                    "",
                    "PID"
                    )["DataTable"];

            if (dtUserInf.Rows.Count > 0) {
                return true;
            }
            else {
                return false;
            }
        }
    }
}
