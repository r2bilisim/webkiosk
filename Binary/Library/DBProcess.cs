using System;
using System.Collections;
using System.Collections.Generic;
using System.Data;
using System.Data.Common;
using System.Data.Sql;
using System.Data.SqlClient;
using QTU.Classes.HandlingLayer;
using System.Windows.Forms;
using Kiosk;
//--------------------

using MySql.Data.MySqlClient;

namespace QCU.Library.Classes
{
    class DBProcess
    {
        public class Settings
        {
            public static string ConnectionString = CreateConString();

            private static string CreateConString()
            {
                string ConStr = string.Empty;


                string DataSource = Kiosk.Properties.Settings.Default.DataSource;
                string DbName = Kiosk.Properties.Settings.Default.DbName;
                string DBUserName = Kiosk.Properties.Settings.Default.DBUserName;
                string DBPass = Kiosk.Properties.Settings.Default.DBPass;

                ConStr = string.Format("Data Source={0};Initial Catalog={1};User ID={2};Password={3}",
                    DataSource, DbName, DBUserName, DBPass);
                return ConStr;
            }

            //public static string Provider = "System.Data.SqlClient";
            public static string Provider = "MySql.Data.MySqlClient";
            public static DbProviderFactory Factory = DbProviderFactories.GetFactory(Provider);
        }

        #region SELECT
        public static Hashtable SimpleQuery(string TableName, string Where, string OrderBy,
            string Columns)
        {
            Hashtable HT = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    try
                    {
                        Conn.Open();
                    }
                    catch
                    {
                        MessageBox.Show(QSError.GiveErrorMessage(QSError.ErrorCodes.VeritabaninaUlasilamiyor));
                        Environment.Exit(0);
                    }

                    DataSet DS = new DataSet();
                    DataTable DT = new DataTable();
                    DbDataAdapter DAP = Settings.Factory.CreateDataAdapter();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    string strCommand = "SELECT " + Columns + " FROM " + TableName + " " + Where + " " + OrderBy;
                    Comm.CommandText = strCommand;
                    DAP.SelectCommand = Comm;
                    DAP.Fill(DS);
                    DAP.Fill(DT);
                    HT.Add("DataSet", DS);
                    HT.Add("DataTable", DT);
                    HT.Add("DataCount", DS.Tables[0].Rows.Count);
                    Conn.Close();
                    DAP.Dispose();
                    Comm.Dispose();
                }
            }
            catch (Exception Ex)
            {
                HT.Add("Error", Ex.Message);
            }
            return HT;
        }

        public static string SimpleTextQuery(string TableName, string Where, string OrderBy, string Columns)
        {
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DataSet DS = new DataSet();
                    DataTable DT = new DataTable();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    string strCommand = "SELECT " + Columns + " FROM " + TableName + " " + Where + " " + OrderBy;
                    Comm.CommandText = strCommand;
                    Comm.Connection = Conn;
                    string returnValue = Comm.ExecuteScalar().ToString();
                    Conn.Close();
                    Comm.Dispose();
                    return returnValue;
                }
            }
            catch
            {
                return "<!error!>";
            }
        }

        public static Hashtable SecurityQuery(string TableName, Hashtable Where, string OrderBy, string Columns)
        {
            Hashtable HT = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DataSet DS = new DataSet();
                    DataTable DT = new DataTable();
                    DbDataAdapter DAP = Settings.Factory.CreateDataAdapter();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    Comm.CommandText = "SELECT " + Columns + " FROM " + TableName + " {0} " + OrderBy;
                    string strWhere = "";
                    int qCount = 0;
                    foreach (string var in Where.Keys as ICollection)
                    {
                        if (var[0] != '@')
                        {
                            if ((qCount / 2) == 0)
                            {
                                strWhere += " " + Where["@" + qCount] + " ";
                            }
                            strWhere += "[" + var + "] = @" + var + " ";
                            qCount++;

                            DbParameter Parameter = Settings.Factory.CreateParameter();
                            Parameter.ParameterName = "@" + var;
                            Parameter.Value = Where[var];
                            Comm.Parameters.Add(Parameter);
                        }
                    }
                    strWhere = "Where " + strWhere;
                    string strCommand = string.Format(Comm.CommandText, strWhere);
                    Comm.CommandText = strCommand;
                    DAP.SelectCommand = Comm;
                    DAP.Fill(DS);
                    DAP.Fill(DT);
                    HT.Add("DataSet", DS);
                    HT.Add("DataTable", DT);
                    HT.Add("DataCount", DS.Tables[0].Rows.Count);
                    Conn.Close();
                    DAP.Dispose();
                    Comm.Dispose();
                }
            }
            catch (Exception Ex)
            {
                HT.Add("Error", Ex.Message);
            }
            return HT;
        }
        #endregion
        #region INSERT

        public static Hashtable InsertData(string TableName, Hashtable ColumnsValues)
        {
            Hashtable rHt = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    string Values = "";
                    string Columns = "";
                    int i = 0;
                    foreach (string var in ColumnsValues.Keys as ICollection)
                    {
                        i++;
                        Columns += var;
                        Values += "@" + var;
                        if (i != ColumnsValues.Keys.Count)
                        {
                            Columns += ",";
                            Values += ",";
                        }

                        DbParameter Parameter = Settings.Factory.CreateParameter();
                        Parameter.ParameterName = "@" + var;
                        if (var == "MusteriNo")
                            Parameter.Value = FormTusTakimi.tcno;
                        else
                            Parameter.Value = ColumnsValues[var];

                        Comm.Parameters.Add(Parameter);
                    }
                    string strCommand = "INSERT INTO " + TableName + "(" + Columns + ") VALUES(" + Values + ")";
                    Comm.CommandText = strCommand;
                    Comm.ExecuteNonQuery();
                    DbCommand IComm = Settings.Factory.CreateCommand();
                    IComm.CommandText = "SELECT @@IDENTITY";
                    IComm.Connection = Conn;
                    try
                    {
                        int intIdentity = Convert.ToInt32(IComm.ExecuteScalar());
                        rHt.Add("Identity", intIdentity);
                    }
                    catch
                    {
                    }


                    Conn.Close();
                    Comm.Dispose();
                    IComm.Dispose();
                    return rHt;
                }
            }
            catch (Exception Ex)
            {
                rHt.Add("Error", Ex.Message);
                return rHt;
            }
        }

        public static Hashtable InsertDataChecked(string TableName, Hashtable ColumnsValues, string Where, string IdentityColumn)
        {
            Hashtable rHt = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    string strIdentity = "";
                    Comm.CommandText = "SELECT " + IdentityColumn + " From " + TableName + " Where " + Where;
                    Comm.Connection = Conn;
                    DbDataReader DR = Comm.ExecuteReader();
                    if (DR.Read())
                    {
                        strIdentity = DR[IdentityColumn].ToString();
                    }
                    DR.Dispose();
                    Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    if (strIdentity == "")
                    {
                        string Values = "";
                        string Columns = "";
                        int i = 0;
                        foreach (string var in ColumnsValues.Keys as ICollection)
                        {
                            i++;
                            Columns += "[" + var + "]";
                            Values += "@" + var;
                            if (i != ColumnsValues.Keys.Count)
                            {
                                Columns += ",";
                                Values += ",";
                            }
                            DbParameter Parameter = Settings.Factory.CreateParameter();
                            Parameter.ParameterName = "@" + var;
                            Parameter.Value = ColumnsValues[var];
                            Comm.Parameters.Add(Parameter);
                        }
                        string strCommand = "INSERT INTO " + TableName + "(" + Columns + ") VALUES(" + Values + ")";
                        Comm.CommandText = strCommand;
                        Comm.ExecuteNonQuery();
                        DbCommand IComm = Settings.Factory.CreateCommand();
                        IComm.CommandText = "SELECT @@IDENTITY";
                        IComm.Connection = Conn;
                        strIdentity = IComm.ExecuteScalar().ToString();
                        rHt.Add("BeforeAdded", false);
                        IComm.Dispose();
                        Conn.Close();
                        Comm.Dispose();
                    }
                    else
                    {
                        rHt.Add("BeforeAdded", true);
                    }
                    rHt.Add("Identity", Convert.ToInt32(strIdentity));
                    Conn.Close();
                    Comm.Dispose();
                    return rHt;
                }
            }
            catch (Exception Ex)
            {
                rHt.Add("Error", Ex.Message);
                return rHt;
            }
        }
        #endregion
        #region UPDATE
        public static Hashtable UpdateData(string TableName, string Where, Hashtable ColumnsValues)
        {
            Hashtable rHt = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    string ColVal = "";
                    int i = 0;
                    foreach (string var in ColumnsValues.Keys as ICollection)
                    {
                        i++;
                        ColVal += var + " = @" + var;
                        DbParameter Parameter = Settings.Factory.CreateParameter();
                        Parameter.ParameterName = "@" + var;
                        Parameter.Value = ColumnsValues[var];
                        Comm.Parameters.Add(Parameter);
                        if (i != ColumnsValues.Keys.Count)
                        {
                            ColVal += ",";
                        }
                    }
                    Comm.CommandText = "UPDATE " + TableName + " SET " + ColVal + " " + Where;
                    Comm.ExecuteNonQuery();
                    Conn.Close();
                    Comm.Dispose();
                    return rHt;
                }
            }
            catch (Exception Ex)
            {
                rHt.Add("Error", Ex.Message);
                return rHt;
            }
        }
        #endregion
        #region DELETE
        public static Hashtable DeleteData(string TableName, string Where)
        {
            Hashtable HT = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.CommandText = "DELETE From " + TableName + " " + Where;
                    Comm.Connection = Conn;
                    Comm.ExecuteNonQuery();
                    Conn.Close();
                    Comm.Dispose();
                }
            }
            catch (Exception Ex)
            {
                HT.Add("Error", Ex.Message);
            }
            return HT;
        }
        #endregion
        #region OTHERS
        public static Hashtable ExecuteSQL(string strSqlCommand)
        {
            Hashtable HT = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DataSet DS = new DataSet();
                    DataTable DT = new DataTable();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.CommandText = strSqlCommand;
                    Comm.Connection = Conn;
                    HT.Add("Value", Comm.ExecuteScalar());
                    Conn.Close();
                    Comm.Dispose();
                }
            }
            catch (Exception Ex)
            {
                HT.Add("Error", Ex.Message);
            }
            return HT;
        }
        public static DataSet ExecuteDataset(string strSqlCommand)
        {
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DataSet DS = new DataSet();
                    DbDataAdapter DAP = Settings.Factory.CreateDataAdapter();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.CommandText = strSqlCommand;
                    Comm.Connection = Conn;
                    DAP.SelectCommand = Comm;
                    DAP.Fill(DS);
                    return DS;
                }
            }
            catch { return null; }
        }
        public static Hashtable ExecuteWithParameter(string strSqlCommand, Dictionary<string, object> dicParams)
        {
            Hashtable HT = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DataSet DS = new DataSet();
                    DataTable DT = new DataTable();
                    DbDataAdapter DAP = Settings.Factory.CreateDataAdapter();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    Comm.CommandText = strSqlCommand;
                    DAP.SelectCommand = Comm;
                    foreach (var item in dicParams)
                    {
                        DbParameter Param = Settings.Factory.CreateParameter();
                        Param.ParameterName = item.Key;
                        Param.Value = item.Value;

                        Comm.Parameters.Add(Param);
                    }
                    DAP.Fill(DS);
                    DAP.Fill(DT);
                    HT.Add("Command", Comm.CommandText);
                    HT.Add("DataSet", DS);
                    HT.Add("DataTable", DT);
                    HT.Add("DataCount", DS.Tables[0].Rows.Count);
                    Conn.Close();
                    DAP.Dispose();
                    Comm.Dispose();
                }
            }
            catch (Exception Ex)
            {
                HT.Add("Error", Ex.Message);
            }
            return HT;
        }
        public static Hashtable InsertCheckedUpdate(string TableName, Hashtable ColumnsValues, string Where, string IdentityColumn)
        {
            Hashtable rHt = new Hashtable();
            try
            {
                using (DbConnection Conn = Settings.Factory.CreateConnection())
                {
                    Conn.ConnectionString = Settings.ConnectionString;
                    Conn.Open();
                    DbCommand Comm = Settings.Factory.CreateCommand();
                    string strIdentity = "";
                    Comm.CommandText = "SELECT " + IdentityColumn + " From " + TableName + " Where " + Where;
                    Comm.Connection = Conn;
                    DbDataReader DR = Comm.ExecuteReader();
                    if (DR.Read())
                        strIdentity = DR[IdentityColumn].ToString();
                    DR.Dispose();
                    Comm = Settings.Factory.CreateCommand();
                    Comm.Connection = Conn;
                    string Values = "";
                    string Columns = "";
                    int i = 0;
                    foreach (string var in ColumnsValues.Keys as ICollection)
                    {
                        i++;
                        Columns += "[" + var + "]";
                        Values += "@" + var;
                        if (i != ColumnsValues.Keys.Count)
                        {
                            Columns += ",";
                            Values += ",";
                        }
                        DbParameter Parameter = Settings.Factory.CreateParameter();
                        Parameter.ParameterName = "@" + var;
                        Parameter.Value = ColumnsValues[var];
                        Comm.Parameters.Add(Parameter);
                    }
                    if (strIdentity == "")
                        Comm.CommandText = "INSERT INTO " + TableName + "(" + Columns + ") VALUES(" + Values + ")";
                    else
                    {
                        string strCommand = "";
                        string[] sColumns = Columns.Split(',');
                        string[] sValues = Values.Split(',');
                        for (i = 0; i < sColumns.Length; i++)
                        {
                            strCommand += sColumns[i] + "=" + sValues[i];
                            strCommand += i != sColumns.Length - 1 ? "," : "";
                        }
                        Comm.CommandText = "UPDATE " + TableName + " SET " + strCommand + " WHERE " + Where;
                    }
                    Comm.ExecuteNonQuery();
                    if (strIdentity == "")
                    {
                        DbCommand IComm = Settings.Factory.CreateCommand();
                        IComm.CommandText = "SELECT @@IDENTITY";
                        IComm.Connection = Conn;
                        strIdentity = IComm.ExecuteScalar().ToString();
                        rHt.Add("BeforeAdded", false);
                        IComm.Dispose();
                    }
                    Conn.Close();
                    Comm.Dispose();
                    if (strIdentity != "")
                        rHt.Add("BeforeAdded", true);
                    rHt.Add("Identity", Convert.ToInt32(strIdentity));
                    Conn.Close();
                    Comm.Dispose();
                    return rHt;
                }
            }
            catch (Exception Ex)
            {
                rHt.Add("Error", Ex.Message);
                return rHt;
            }
        }
        #endregion

        #region BASIC OTHERS

        public DBProcess(string ConStr)
        {
        }

        private static SqlConnection GetCon()
        {
            SqlConnection con = new SqlConnection(Settings.ConnectionString);
            con.Open();
            return con;
        }

        public static DataTable SelectProcess(string SqlSelect)
        {
            SqlDataAdapter dtAdptr = new SqlDataAdapter(SqlSelect, GetCon());
            DataTable dt = new DataTable();
            dtAdptr.Fill(dt);
            return dt;
        }

        public static int InsertUpdateProcess(string SqlInsertUpdate)
        {
            SqlCommand cmd = new SqlCommand(SqlInsertUpdate, GetCon());
            GetCon().Close();
            return cmd.ExecuteNonQuery();
        }
        #endregion
    }
}
