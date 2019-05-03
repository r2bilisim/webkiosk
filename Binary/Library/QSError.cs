using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace QTU.Classes.HandlingLayer {
					public static class QSError {
								public enum ErrorCodes {
												AgBaglantisiYok = 0x0001,
												VeritabaninaUlasilamiyor = 0x0002,
												ComPortKullanimda = 0x0003,
												ComPortGenelHata = 0x0004,
												QPUUlasilamazDurumda = 0x0005,
												KioskIDHatali = 0x0006,
												KioskAyariYok = 0x0007,
												AnaDisplayUlasilamazDurumda = 0x0008,
												BiletMakinesiUlasilamazDurumda = 0x0009,
												ElTerminaliUlasilamazDurumda = 0x0010
		}

												public static string GiveErrorMessage( ErrorCodes _ErrCode ) {
			string rv_ErrorMessage = string.Empty;

			switch ( _ErrCode ) {
				case ErrorCodes.AgBaglantisiYok:
					rv_ErrorMessage = string.Format(
						"Ağ bağlantısı yok. Lütfen ağ bağlantı ayarlarını kontrol edin.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.AgBaglantisiYok).ToString( "X4" ) );
					break;
				case ErrorCodes.VeritabaninaUlasilamiyor:
					rv_ErrorMessage = string.Format(
						"Veritabanına ulaşılamıyor! Lütfen veritabanı ayarlarınızı kontrol edin ve veritabanı hizmetinin çalışır durumda olduğundan emin olun.{0}Hata Kodu: {1}",
						Environment.NewLine, "0x" + ((int)ErrorCodes.VeritabaninaUlasilamiyor).ToString( "X4" ) );
					break;
				case ErrorCodes.ComPortKullanimda:
					rv_ErrorMessage = string.Format(
						"Erişilmeye çalışılan Com Port kullanımda! Lütfen ilgili numaralı Com Port'u kullanan programı kapatarak tekrar deneyin.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.ComPortKullanimda).ToString( "X4" ) );
					break;
				case ErrorCodes.ComPortGenelHata:
					rv_ErrorMessage = string.Format(
						"Erişilmeye çalışılan Com Port bilgisayar üzerinde bulunmuyor! Lütfen ilgili numaralı Com Port'u kontrol edin.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.ComPortGenelHata).ToString( "X4" ) );
					break;
				case ErrorCodes.QPUUlasilamazDurumda:
					rv_ErrorMessage = string.Format(
						"Server programı QPU açık değil veya ulaşılmaz durumda! Lütfen QPU'nun çalışıp çalışmadığını, ağ bağlantı ayarlarınızı ve güvenlik duvarı ayarlarınızı kontrol edin.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.QPUUlasilamazDurumda).ToString( "X4" ) );
					break;
				case ErrorCodes.KioskIDHatali:
					rv_ErrorMessage = string.Format(
						"Kiosk ID değeri hatalı yapılandırılmış! Lütfen Kiosk ID değerini düzeltiniz.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.KioskIDHatali).ToString( "X4" ) );
					break;
				case ErrorCodes.KioskAyariYok:
					rv_ErrorMessage = string.Format(
						"Kioska ait ayarlar yapılandırılmamış! Lütfen QCU üzerinden kioska ait ayarları yapın. Kiosk programı şimdi kapatılacak.{0}Hata Kodu: {1}",
				Environment.NewLine, ((int)ErrorCodes.KioskAyariYok).ToString( "X4" ) );
					break;
				case ErrorCodes.AnaDisplayUlasilamazDurumda:
					rv_ErrorMessage = string.Format(
						"Ana Display sistemde mevcut değil! Lütfen kayıt değerlerini ve ana displayin sistemde bulunup bulunmadığını kontrol ediniz.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.AnaDisplayUlasilamazDurumda).ToString( "X4" ) );
					break;
				case ErrorCodes.BiletMakinesiUlasilamazDurumda:
					rv_ErrorMessage = string.Format(
						"Bilet makinesi sistemde mevcut değil! Lütfen kayıt değerlerini ve bilet makinesinin sistemde bulunup bulunmadığını kontrol ediniz.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.BiletMakinesiUlasilamazDurumda).ToString( "X4" ) );
					break;
				case ErrorCodes.ElTerminaliUlasilamazDurumda:
					rv_ErrorMessage = string.Format(
						"El terminal cihazı sistemde mevcut değil! Lütfen kayıt değerlerini ve el terminal cihazının sistemde bulunup bulunmadığını kontrol ediniz.{0}Hata Kodu: {1}",
						Environment.NewLine, ((int)ErrorCodes.ElTerminaliUlasilamazDurumda).ToString( "X4" ) );
					break;
				default:
					rv_ErrorMessage = "Beklenmeyen hata meydana geldi! Hata Kodu: 0x0000";
					break;
			}

			return rv_ErrorMessage;
		}
	}
}
