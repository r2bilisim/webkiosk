<?php
	/*
		-- =============================================
		-- Author:		EKOMURCU
		-- Create date: 20.03.2019
		-- Description:	buton.php,index.php den ajax ile gelen datayı işler ve  escpos ile direk yazıcıdan çıktı alır.
		-- ============================================= 
	*/	
?>
<?php
	require __DIR__ . '/../../autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;	
	try {
		
		if(isset($_POST['yaziciAdi']) && isset($_POST['biletresim']) && isset($_POST['kopyasayisi']))
		{						
			$klasor="biletler";
			$ad="bilet.png";
			$img = $_POST['biletresim'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
			
			$yol="./".$klasor."/".$ad;	
			if(!file_exists($klasor))
			{
				mkdir($klasor);
			}
			//resmi yaz
			file_put_contents($yol, $fileData);			
		}	
			try { $img = EscposImage::load($yol, false); }
			catch(Exception $e) { unlink($yol);	throw $e; }		
			
		/* Print it */
		//yazıcı ile bağlantı kur
		$connector = new WindowsPrintConnector($_POST['yaziciAdi']);
		$printer = new Printer($connector);
		//kaç kopya olacaksa o kadar yazdır
		$Copies = $_POST['kopyasayisi'];
		$Count=1;
		while ($Count <= $Copies){
					
			$printer = new Printer($connector);
			$printer -> bitImage($img);
			$printer -> cut(); //kesme komudu
			$Count++;								
		}
		//yazıcıyı sonlandır
		$printer -> close();		
		} catch(Exception $e) {
		echo "hata___".$e -> getMessage();
	}
	
?>