using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using System.Collections;
using QCU.Library.Classes;

namespace QVU.Classes {
    class UserLogin {
        #region Members/Properties
                                public int PersonelID { get; set; }
                                private string Username { get; set; }
                                private string Pass { get; set; }
                                public int TerminalID { get; set; }
                                public string Ad { get; set; }
                                public string Soyad { get; set; }
        #endregion
        
        
        
        
        #region Methods
                                                        public bool Login( string p_UserName, string p_Pass ) {
            Username = p_UserName;
            Pass = p_Pass;

            
            DataTable dtUserInf = (DataTable)DBProcess.SimpleQuery(
                    "PERSONELLER",
                    "WHERE KULLANICI_ADI='" + Username + "' AND SIFRE='" + Pass + "'",
                    "",
                    "PID, TID, AD, SOYAD"
                    )[ "DataTable" ];

            if ( dtUserInf.Rows.Count > 0 ) {
                this.PersonelID = int.Parse( dtUserInf.Rows[ 0 ][ "PID" ].ToString() );
                this.Ad = dtUserInf.Rows[ 0 ][ "AD" ].ToString();
                this.Soyad = dtUserInf.Rows[ 0 ][ "SOYAD" ].ToString();
                this.TerminalID = int.Parse( dtUserInf.Rows[ 0 ][ "TID" ].ToString() );

                
              
                return true;
            }
            else {
                return false;
            }
        }

                                        public void UpdateLoginState( bool IsLogin ) {
            Hashtable hshUpdateStates = new Hashtable();
            hshUpdateStates.Add( "OTURUM_DURUM", IsLogin );

            DBProcess.UpdateData( "PERSONELLER", "WHERE PID = " + this.PersonelID, hshUpdateStates );
        }
        #endregion
    }
}
