<html>
	<head>
		<title><?=$pagetitle?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="author" content="PowerComputers Telecommunication Ltd." />
		<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
		
		<!--Style sheet for validation-->
		<link href="css/StyleSheet.css" media="screen" rel="stylesheet" type="text/css"/>
		<!--End-->
		
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/metro.css">
		<link rel="stylesheet" href="css/metro-icons.css">
		<link rel="stylesheet" href="css/metro-responsive.css">
		<link rel="stylesheet" href="css/metro-rtl.css">
		<link rel="stylesheet" href="css/metro-schemes.css">
		
		<script src="js/jquery.min.js"></script>
		<script src="js/datatables.js"></script>
		<script src="js/select2.min.js"></script>
		
		<!-- Metro UI CSS JavaScript plugins -->
		<script src="js/metro.js"></script>
		
	</head>
	<body class="metro">
		<div id="menu">
			<?=$menu?>
		</div>
		<div class="grid" style="margin-top:0 !important;">
			<?=$content?>
		</div>
		<script type='text/javascript'>
			function triggerError(msg, o) {
				$.Notify({
					content: msg,
					style: {background:'#ff2d19',color:'white'}
				});	
				return false;
			}
			
			function triggerMessage(msg, o) {
				$.Notify({
					content: msg,
					style: {background:'#7ad61d',color:'white'}
				});
				return false;
			}
			
			$(function(){
				try {
					<?php if ( $error ) { echo 'triggerError("'.$error.'",null)'; } ?>;
					<?php if ( $message ) { echo 'triggerMessage("'.$message.'",null)'; } ?>;
				}
				catch (e) {}
				
				addClasses();
			});
			
			function addClasses() {
				$('.crm_table th').addClass('<?=TableHead.' '.TableHeadText?>');
				$('input:button,input:submit,.styled').addClass('<?=ButtonBkgText?>');
			}
		</script>
	</body>
</html>