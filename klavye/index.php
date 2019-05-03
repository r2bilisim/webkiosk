	<!-- demo -->
	<!--bunu açarsan siyah tema olur 
	<link href="klavye/css/bootstrap.min.css" rel="stylesheet">
	<link href="klavye/css/font-awesome.min.css" rel="stylesheet">
	<!-- <link href="klavye/css/demo.css" rel="stylesheet"> -->

	<!-- jQuery & jQuery UI + theme (required) -->
	<link href="klavye/css/jquery-ui.min.css" rel="stylesheet">
	<script src="klavye/js/jquery-latest.min.js"></script>
	<script src="klavye/js/jquery-ui.min.js"></script>
	<script src="klavye/js/bootstrap.min.js"></script>

	<!-- keyboard widget css & script (required) -->
	<link href="klavye/css/keyboard.css" rel="stylesheet">
	<script src="klavye/js/jquery.keyboard.js"></script>

	<!-- keyboard extensions (optional) -->
	<script src="klavye/js/jquery.mousewheel.js"></script>
	<!--
	<script src="../js/jquery.keyboard.extension-typing.js"></script>
	<script src="../js/jquery.keyboard.extension-autocomplete.js"></script>
	-->

	<!-- initialize keyboard (required) -->
	<style type="text/css">
button.ui-keyboard-button.btn {
	padding: 1px 6px;
	font-size:50px
}
#txtBarkod{
	font-size:30pt;height:auto;width:auto;padding:5px;background:white;color:red;
}
	</style>
	<script>
		$(function(){	
			$('#txtBarkod')
	.keyboard({
	layout: 'custom',
	restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
		preventPaste : true,  // prevent ctrl-v and right click
		autoAccept : true,
		display: {
		'bksp'   : 'Sil',
		'enter'  : 'Onayla',		
		'accept' : 'Onayla2'
	},
	usePreview: false, // no preveiw
	css: {
			// input & preview
			// "label-default" for a darker background
			// "light" for white text
			input: 'form-control input-sm dark',
			// keyboard container
			container: 'center-block well',
			// default state
			buttonDefault: 'btn btn-default',
			// hovered button
			buttonHover: 'btn-primary',
			// Action keys (e.g. Accept, Cancel, Tab, etc);
			// this replaces "actionClass" option
			buttonAction: 'active',
			// used when disabling the decimal button {dec}
			// when a decimal exists in the input area
			buttonDisabled: 'disabled'
		},
		customLayout: {
			'normal' : [				
				'7 8 9 ',
				'4 5 6',
				'1 2 3',
				'0',
				'{bksp} {a} {c}'
			]
		},
		maxLength : 11,

		// activate the "validate" callback function
		acceptValid : true,
		/*validate : function(keyboard, value, isClosing){
			// only make valid if input is 6 characters in length
			return value.length === 11;
		}, */
		accepted : function(e, keyboard, el){ 
		$.ajax({
                type: "POST",
                url: "barkodluBilet.php",
                data: $("#formBarkod").serialize(),
				beforeSend: function() {
				 //$('.modal-body').html('<img src=dist/img/ajax-loader.gif>');
			  },
                success: function(msg) {
					//bilet ön izleme
					$('#txtBarkod').val("");
					//$('#mesaj').html(msg);
					
					$("#mesaj").fadeIn(1000); 
					$("#mesaj").fadeOut(2000); 
                    $('.modal-body').html(msg);	
					
					//bilet modal'ini tetikleyen buton
					$("#btn").click();					
					//$('.modal-print').html(msg);	
					/*bilet yazdýr	
					  var Copies = <?php echo $biletKopyaSayisi=1; ?>;
					  var Count=1;
					  while (Count <= Copies){
					 $( "#biletx" ).print();
						Count++;
                   
					  }	// */		   
					  
		}}); }
	})
	.addTyping();
		});
	</script>