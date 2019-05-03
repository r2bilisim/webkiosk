<?php 
function GetHasta($BtnID, $KID)
        {
            $sunucu = "localhost"; //10.206.148.6
            $veritabani = "qcu"; //META_SPDB
            $kullanici = "sa"; //OMES
            $parola = "1234"; //Omes06
        try 
		{
			$db = new PDO("sqlsrv:Server=$sunucu;Database=$veritabani", "$kullanici", "$parola"); 		
			$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");	
			
			   $procedure = '{:sonuc = CALL sp_GetButtonIDToProperty(@BtnID=:BtnID, @KID=:KID)}';
			   $deyim = $db->prepare($procedure);
			   $sonuc=null;
			   $deyim->bindParam(':sonuc',$sonuc ,PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT,4);			  
								
					echo $sonuc;
											
						$deyim->bindParam(':BtnID',$BtnID,PDO::PARAM_INT);
						$deyim->bindParam(':KID',$KID,PDO::PARAM_INT);
						$deyim->execute();	

			return $deyim->fetch();
					//$results = array();
					//do {
					//	$results []= $deyim->fetchAll();
					//} while ($deyim->nextRowset());
					
					//return $results[0];
		} 
		catch(PDOException $e ){ print $e->getMessage(); }  
		                                                                                                                                                     
             
		}
		$BtnID=1;
		$KID=129;
		print_r(GetHasta($BtnID, $KID));
		echo "<hr>";
		
		echo GetHasta($BtnID, $KID)["BTNID"]."<br>";
		echo GetHasta($BtnID, $KID)["BM_ADRES"]."<br>";
		
?>