<?php	

	function loadExcelTemplate($filename, $tpl, $data) {
		include 'lib/excel/Worksheet.php';
		include 'lib/excel/Workbook.php';
		extract ( (array) $data );
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$filename".".xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");
		
		// Creating a workbook
		$workbook = new Workbook("-");

		$header =& $workbook->add_format();
		$header->set_size(10);
		$header->set_bold(true);
		$header->set_align('left');
		$header->set_color('white');
		$header->set_pattern();
		$header->set_fg_color('black');

		@include 'templates/excel/' . $tpl ;		
		
		$workbook->close();
		die();
	}
	
	function loadTemplate($tpl, $data=array(), $filename="") {
		global $templateData;
		global $format;
		
		global $module;
		global $action;

		if ( $format == 'excel' and file_exists('views/excel/'.$tpl) ) {
			if ( empty($filename) ) $filename = 'excel_output';
			$filename .= '_' . date('dMy');
			loadExcelTemplate($filename,$tpl,$data);
		} else {
	
			if ( ! empty($data) ) {
				$data = array_merge((array)$data, (array)$templateData);
				$templateData = $data;
			}
			extract ( (array) $data );


			ob_start();
			@include 'views/' . $tpl ;
			
			// Remove when deploying on Client PC!
			if ( $format == 'excel' ) echo '<script>alert("Excel File Not Available for Download")</script>';
			
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	
	function cleanInput($str) {
		return trim($str);
	}
	
	function loadDir($dir) {
		global $config;
		if ( is_dir($dir) ) {
			$d = opendir($dir);
			while ($file = readdir($d)) {
				if ( substr($file,-4)=='.php' ) include $dir . $file;
			}
		}
	}
	
	function url($module, $action, $params="") {
		if ( is_array($params) ) {
			$str_params = '';
			foreach($params as $k=>$v) $str_params .= $k .'=' . urlencode($v) . '&';
			$params = $str_params;
		} else {
			if (!empty($params)) $params.='&';
		}
		return '?' . $params . 'module=' . $module . '&action=' . $action;
	}
	
	function base_url() {
		return '';
	}
	
	function getSession($key) {
		$keyParts = explode('.',$key);
		$output = '';
		foreach($keyParts as $keyPart) {
			if ( empty($output) )  $output = $_SESSION[$keyPart];
			else{
				if ( is_array($output) ) {
					$output = $output[$keyPart];
				}	
				if ( is_object($output) ) {
					$output = $output->$keyPart;
				}
			}
		}
		return $output;
	}
	
	function redirect($module, $action, $params="") {
		$url = url($module,$action,$params);
		header('Location: ' . $url);
		die();
	}
	
	function redirectBack() {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		die();
	}
	
	function getAction() {
		global $action;
		return $action;
	}
	
	function getModule() {
		global $module;
		return $module;
	}
	
	function selected($a,$b,$val1='selected',$val2='') {
		return $a==$b?$val1:$val2;
	}
	
	function fDate($dt, $format='jS F Y') {
		return date($format,strtotime($dt));
	}
	
	function resizeUploadImage($img,$refwidth=200,$refheight=0,$uploadloc,$format='jpg') {
		$size = getimagesize($img["tmp_name"]);
		
		if ($size) {
			$extension = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
			
			$imgpath['name'] = strtolower($imgpath['name']);
			
			if($extension == "gif")	{ $imgconv = imagecreatefromgif($img["tmp_name"]);	}
			elseif($extension == "jpg" || $extension == "jpeg")	{ $imgconv = imagecreatefromjpeg($img["tmp_name"]);	}
			else if($extension=="png") { $imgconv = imagecreatefrompng($img["tmp_name"]); }
			
			list($imgwidth,$imgheight) = getimagesize($img["tmp_name"]); //current image dimensions
			
			$ctrl_imgwidth = $refwidth;
			
			if ($refheight == 0) { //new size
				$new_imgheight = ($imgheight/$imgwidth)*$ctrl_imgwidth;
			} else {
				$new_imgheight = $refheight;
			}
			
			$tmp_img = imagecreatetruecolor($ctrl_imgwidth,$new_imgheight);
			if ($format == 'png') { //transparency
				imagealphablending( $tmp_img, false );
				imagesavealpha( $tmp_img, true );
			}
			
			//Resize the image file
			imagecopyresampled($tmp_img,$imgconv,0,0,0,0,$ctrl_imgwidth,$new_imgheight,$imgwidth,$imgheight);
			
			//Upload the image
			$time = time();
			$imgname = $time.'-'.$img['name'];
			$uploadloc .= $imgname;
			if ($format == 'jpg') {
				imagejpeg($tmp_img,$uploadloc,100);
			} else if ($format == 'png') {
				imagepng($tmp_img,$uploadloc,9);
			}

			imagedestroy($imgconv);
			imagedestroy($tmp_img);	
			
			return $imgname;
		}
	}
?>