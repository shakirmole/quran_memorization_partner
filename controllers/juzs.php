<?

	if ( $action == 'index' ) {
		$tData['juzs'] = $Juzs->getAll('jno');
		
		$data['content'] = loadTemplate('juz_wise.tpl.php',$tData);
	}
	
	if ($action == 'ajax_getVerses' ) {
		$id = $_GET['id'];
		
		$verses = $Juzs->getVerses($id);
		$response = array();
		
		foreach ($verses as $val=>$row) {
			$obj=null;
			$obj->id=$row['id'];
			$obj->vno=$row['vno'];
			$obj->sno=$row['sno'];
			$obj->sura=$row['sura'];
			$obj->text=$row['text'];
			$response[]=$obj;
		}
		$data['content']=$response;
	}


?>