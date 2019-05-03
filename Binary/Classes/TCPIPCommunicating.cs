
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net.Sockets;
using QPU_TCPIP.Classes.SysConfigration;
using System.Net;

namespace Kiosk.Binary.Classes
{
    public static class TCPIPCommunicating
    {
        #region Members/Propertieses

        #endregion





        #region Methods

        public static bool CheckQPUServer()
        {
            byte[] outStream;
            TcpClient tcpClient = null;
            NetworkStream serverStream = null;

            try
            {
                ServerConfig serverConfigrations = new ServerConfig();
                //IPAddress serverIP = IPAddress.Parse(serverConfigrations.ServerIP);
                string serverIP = serverConfigrations.ServerIP;

                tcpClient = new TcpClient();
                tcpClient.Connect(serverIP, 90);

                serverStream = tcpClient.GetStream();

                outStream = Encoding.ASCII.GetBytes("#099#000#000#000");
                serverStream.Write(outStream, 0, outStream.Length);

                return true;
            }
            catch (Exception ex)
            {
                return false;
            }
            finally
            {
                if (serverStream != null)
                    serverStream.Flush();

                if (tcpClient.Connected)
                    tcpClient.Close();
            }
        }


        public static bool GlobalReset()
        {
            byte[] outStream;
            TcpClient tcpClient = null;
            NetworkStream serverStream = null;

            try
            {

                ServerConfig serverConfigrations = new ServerConfig();
                //IPAddress serverIP = IPAddress.Parse(serverConfigrations.ServerIP);
                string serverIP = serverConfigrations.ServerIP;
                

                tcpClient = new TcpClient();
                tcpClient.ReceiveTimeout = 3;
                tcpClient.Connect(serverIP, 90);

                serverStream = tcpClient.GetStream();

                string CommandDatas = string.Format("#{0}#{1}#{2}", "085", "000", "000");

                outStream = Encoding.ASCII.GetBytes(CommandDatas);
                serverStream.Write(outStream, 0, outStream.Length);

                return true;
            }
            catch (Exception ex)
            {
                return false;
            }
            finally
            {
                if (serverStream != null)
                    serverStream.Flush();

                if (tcpClient.Connected)
                    tcpClient.Close();
            }
        }

        #endregion
    }
}
