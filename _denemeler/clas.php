<?php

class ClosureTest {
    
    public $getInfo;
    
    public function __construct() {
        $bu = $this; // Yerel degisken olusturuldu (local variable)
        
        $this->getInfo = function() use($bu) {
            echo $bu->getCity(5,4);
            return 'Ben şehir bilgisini getiren metottan sonra çağırıldım.';
        };
    }
    
    public function getCity($a,$b) {
        return $a+$b;
    }
}
$ClosureTest = new ClosureTest;
// Sinif icindeki closure fonksiyona erismek icin once bir degiskene atama yapmalisiniz.
$cT = $ClosureTest->getInfo;
echo $cT();

?>