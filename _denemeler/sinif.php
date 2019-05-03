<?php
	class sinif
	{
		public $degisken;
		
		public function __construct()
		{
			$that=$this;
			$this->degisken=function() use($that){
			return $that->topla(4,5);
			};
		}
		public function topla($a,$b)
		{
			return $a+$b;
		}
		
		
	}

	$nesne= new sinif;
	$a=$nesne->degisken;
	echo $a();
?>