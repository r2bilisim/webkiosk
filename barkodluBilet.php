<?php include('Connections/baglantim.php'); ?>
<?php include("Binary/Classes/tcKimlikSinifi.php");?>
<?php
	if(isset($_POST['txtBarkod']) && is_numeric($_POST['txtBarkod']))
	{
		if(strlen($_POST['txtBarkod'])>0 && strlen($_POST['txtBarkod'])<11)
		{
			$barkod="Dosya no: ".$_POST['txtBarkod']; //yeniBiletOlustur.php içine gidiyor(bilete basılacaksa)			
			//burada grup btnid vs bilgileri ile bilet basılacak(hangi birim için bilet basılacaksa)
			$_POST["GRPID"]=3; $_POST["BTNID"]=2;$_POST["maksimumBilet"]=500;
			include("yeniBiletOlustur.php");
			//GetHasta($_POST['txtBarkod'], "dosyaNo");
			
		}
		else if(strlen($_POST['txtBarkod'])==11)
		{
			$tc=new tcKimlik();
			if($tc->Dogrumu($_POST['txtBarkod']))
			{				
				$barkod="TC: ".$_POST['txtBarkod']." doğrulandı.";
				//burada grup btnid vs bilgileri ile bilet basılacak
				$_POST["GRPID"]=2; $_POST["BTNID"]=1;$_POST["maksimumBilet"]=500;
				include("yeniBiletOlustur.php");
				
				//GetHasta($_POST['txtBarkod'], "tcNo");
			}
			else{
				echo $_POST['txtBarkod']." hatalı tc.";				
			}
							
		}
		else{
			echo "Geçersiz barkod";
		}
	}
	else
	{
		echo "Hatalı barkod";
	}
	function GetHasta($vBarkod, $tur)
        {
            $sunucu = "localhost"; //10.206.148.6
            $veritabani = "qcu"; //META_SPDB
            $kullanici = "sa"; //OMES
            $parola = "1234"; //Omes06
        try 
		{
			$db = new PDO("sqlsrv:Server=$sunucu;Database=$veritabani", "$kullanici", "$parola"); 		
			$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");	
			
			   $procedure = '{:sonuc = CALL HASTA_ISTEMLER (:TC_NO, :DOSYA_NO, :BIRIM_NO) }';
			   $deyim = $db->prepare($procedure);
			   $sonuc=null;
			   $deyim->bindParam(':sonuc',$sonuc ,PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT,4);			  
								
					
					if($tur=="tcNo") 
                    {						
						$deyim->bindParam(':TC_NO',$vBarkod,PDO::PARAM_STR);
						$deyim->bindParam(':DOSYA_NO',"",PDO::PARAM_STR);
						$deyim->bindParam(':BIRIM_NO',"",PDO::PARAM_STR);
						$deyim->execute();	
                    }
                    else if ($tur=="dosyaNo") 
                    {                       	
						$deyim->bindParam(':TC_NO',"",PDO::PARAM_STR);
						$deyim->bindParam(':DOSYA_NO',$vBarkod,PDO::PARAM_STR);
						$deyim->bindParam(':BIRIM_NO',"",PDO::PARAM_STR);
						$deyim->execute();	
                    }
                    else  
                    {
                       exit();                       
                    }										
			return $deyim->fetch();
				/*	$results = array();
					do {
						$results []= $deyim->fetchAll();
					} while ($deyim->nextRowset());
					
					return $results;
					*/
		} 
		catch(PDOException $e ){ print $e->getMessage(); }  
		                                                                                                                                                     
             
		}

?>