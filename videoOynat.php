<?php /*
	-- =============================================
	-- Author:		EKOMURCU
	-- Create date: 06.01.2019
	-- Description:	kioks arkaplanda video oynatma
	-- ============================================= 
*/ ?>
<video id="my-video" class="video" muted loop>
	<source src="media/demo.mp4" type="video/mp4">
</video>

<!-- /video -->
<script>
	(function() {
		/**
			* Video element
			* @type {HTMLElement}
			*/
			var video = document.getElementById("my-video");
			
			/**
				* Check if video can play, and play it
				*/
			//video ayarları için veritabanında bir tablo oluşturulacak! ek. 07.01.2019
			//video.autoplay=true;
			//video.loop=true;
			//video.muted=false;
			//video.volume=0.2;				
			//video.load();
			//video.play();
			
				video.addEventListener( "canplay", function() {				
				video.play();
				});
				
			})();
		</script>						