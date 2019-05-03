<?php
# txtBarkod ile enter işlemi ajax denemesi
?>
<script src="dist/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){

  $('#formBarkod').keypress(function(e) {
    if (e.which == 13) {
    e.preventDefault();
		$.ajax({
                type: "POST",
                url: "Binary/Classes/tcKimlikSinifi.php",
                data: $("#formBarkod").serialize(),
				beforeSend: function() {
				 //$('.modal-body').html('<img src=dist/img/ajax-loader.gif>');
			  },
                success: function(msg) {
					//bilet ön izleme
					alert(msg);
					$('#txtBarkod').val("");
                    //$('.modal-body').html(msg);		
					//$('.modal-print').html(msg);	
					/*bilet yazdır	
					  var Copies = <?php echo $biletKopyaSayisi; ?>;
					  var Count=1;
					  while (Count <= Copies){
					 $( ".modal-body" ).print({bUI: false, bSilent: true, bSchrinkToFit: true});
						Count++;
                   
					  }	*/		   
					  
                    },							
                error:function(ma,ydin)
        {
            if (ma.status === 0) {
                alert('[jquery]Bağlantı yok, ağı doğrulayın.');
            } else if (ma.status == 404) {
                alert('[jquery]Talep edilen sayfa bulunamadı. [404]');
            } else if (ma.status == 500) {
                alert('[jquery]Dahili Sunucu Hatası [500].');
            } else if (ydin === 'parsererror') {
                alert('[jquery]İstenen JSON ayrıştırması başarısız');
            } else if (ydin === 'timeout') {
                alert('[jquery]Zaman aşımı hatası.');
            } else if (ydin === 'abort') {
                alert('[jquery]Ajax isteği reddedildi.');
            } else {
                alert('[jquery]Yakalanmamış Hata.\n' + ma.responseText);
            }
        },        						
              });
	
    
    }
  });

});
 </script>
 <form id="formBarkod" method="post">
 <div id="barkod"><span>Lütfen Barkodunuzu Okutun:</span><input type="text" name="txtBarkod" id="txtBarkod">
 </div>
 </form>