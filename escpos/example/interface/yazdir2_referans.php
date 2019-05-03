<?php
	require __DIR__ . '/../../autoload.php';
	use Mike42\Escpos\Printer;
	use Mike42\Escpos\EscposImage;
	use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
    
	/*
		/*
		* Due to its complxity, escpos-php does not support HTML input. To print HTML,
		* either convert it to calls on the Escpos() object, or rasterise the page with
		* wkhtmltopdf, an external package which is designed to handle HTML efficiently.
		*
		* This example is provided to get you started.
		*
		* Note: Depending on the height of your pages, it is suggested that you chop it
		* into smaller sections, as printers simply don't have the buffer capacity for
		* very large images.
		*
		* As always, you can trade off quality for capacity by halving the width
		* (550 -> 225 below) and printing w/ Escpos::IMG_DOUBLE_WIDTH | Escpos::IMG_DOUBLE_HEIGHT
	*/
	try {
		
		/* Set up command */
		/*
			$source =htmlspecialchars($_POST['test']);
			$width = 550;
			$dest = tempnam(sys_get_temp_dir(), 'escpos') . ".png";
			$cmd = sprintf("\"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe\" %s %s",
			
			escapeshellarg($source),
			escapeshellarg($dest));
		*/
		/* Run wkhtmltoimage 
			ob_start();
			system($cmd); // Can also use popen() for better control of process
			$outp = ob_get_contents();
			ob_end_clean();
			if(!file_exists($dest)) {
			throw new Exception("Command $cmd failed: $outp");
			}
		/* Load up the image */
		
		/*
			header("Content-type: image/png");
			$tuval=imagecreate($TagPreviewWidth,$TagPreviewHeight);
			imagecolorallocate($tuval,255,255,255);
			$siyah=imagecolorallocate($tuval,0,0,0);
			
			imagettftext($tuval,(($biletAyar->PuntoBaslik)*(1.3333)),0,30,30,$siyah,"arial.ttf",($biletAyar->BiletBaslik1));
			imagettftext($tuval,(($biletAyar->PuntoBaslik)*(1.3333)),0,30,30+(($biletAyar->PuntoBaslik)*(1.3333))*2,$siyah,"arial.ttf",($biletAyar->BiletBaslik2));
			imagettftext($tuval,(($biletAyar->PuntoBaslik)*(1.3333)),0,30,30+(($biletAyar->PuntoBaslik)*(1.3333))*4,$siyah,"arial.ttf",($biletAyar->BiletBaslik3));
			
			imagettftext($tuval,(($biletAyar->PuntoBiletNo)*(1.3333)),0,30,30+(($biletAyar->PuntoBiletNo)*(1.3333))*2,$siyah,"arial.ttf",$BILET_NO);
			
			
			imagesetthickness($tuval,5);
			imagerectangle($tuval,0,0,$TagPreviewWidth,$TagPreviewHeight,$siyah);
			imagepng($tuval,"resim.png");
			imagedestroy($tuval);
		*/
		
		if(isset($_POST['biletresim']))
		{						
			$ad="bilet";
			 $data=$_POST['biletresim'];
			 $image_array_1 = explode(";", $data);
			
			$image_array_2 = explode(",", $image_array_1[1]);
			
			$data = base64_decode($image_array_2[1]);
			
			$imageName = $ad.'_1.png';
	$klasor="./".$ad."/";	
	if(!file_exists($klasor))
	{
		mkdir($klasor);
	}
	$yol=$klasor.$imageName;	
	file_put_contents($yol, $data);

		}
		
		/*
		try {
			$img = EscposImage::load($yol, false);
		}
		catch(Exception $e) {
		
			unlink($yol);
			throw $e;
		}
		
		/* Print it */
		/*
		$connector = new WindowsPrintConnector("XP-80C");
		
		/* Print a "Hello world" receipt" */
		/*
		$printer = new Printer($connector);
		$printer -> bitImage($img); // bitImage() seems to allow larger images than graphics() on the TM-T20.
		$printer -> cut();
		$printer -> close();
		*/
		} catch(Exception $e) {
		echo "hata___".$e -> getMessage();
	}		
?>