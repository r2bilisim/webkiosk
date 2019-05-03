using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Collections;
using System.Data;
using QCU.Binary.Classes;

namespace QCU.Interfaces.Classes
{
    interface IDataProcess
    {
                                        DataTable Get();

                                                DataTable Get(string Where);

                                        Hashtable New();

                                        Hashtable Update();

                                                Hashtable Update(string Where);

                                        Hashtable Delete();

                                        Hashtable Delete(string Where);

                    }
}
