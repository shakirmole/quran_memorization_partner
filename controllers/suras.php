<?

	if ( $action == 'index' ) {
		$tData['suras'] = $Suras->getAll('sno');
		
		$data['content'] = loadTemplate('sura_wise.tpl.php',$tData);
	}
	
	if ($action == 'ajax_getVerses' ) {
		$id = $_GET['id'];
		
		$verses = $Suras->getVerses($id);
		$response = array();
		
		foreach ($verses as $val=>$row) {
			$obj=null;
			$obj->id=$row['id'];
			$obj->vno=$row['vno'];
			$obj->text=$row['text'];
			$response[]=$obj;
		}
		$data['content']=$response;
	}


?>