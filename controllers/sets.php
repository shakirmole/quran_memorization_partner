<?

	if ( $action == 'index' ) {
		$tData['sets'] = $Sets->getAll();
		// print_r($tData['juzs']);
		
		$data['content'] = loadTemplate('set_add.tpl.php',$tData);
	}
	
	if ( $action == 'set_save' ) {
		
		$miniData = $_POST['set'];
		$Sets->insert($miniData);
		
		$_SESSION['message'] = 'Set Saved';
		redirectBack();
	}
	
	if ( $action == 'set_edit' ) {
		$id = $_GET['id'];
		$tData['set'] = $Sets->getDetails($id);
		$tData['sets'] = $Sets->getAll();
		
		$tData['suras'] = $SetSuras->search($id);
		$tData['juzs'] = $SetJuzs->search($id);
		$tData['verses'] = $SetVerses->search($id);
		
		$data['content'] = loadTemplate('set_edit.tpl.php',$tData);
	}
	
	if ( $action == 'set_update' ) {
		
		$id = $_POST['id'];
		$miniData = $_POST['set'];
		$Sets->update($id,$miniData);
		
		$juzs = $_POST['juz'];
		$suras = $_POST['sura'];
		$fvids = $_POST['fvid'];
		$tvids = $_POST['tvid'];
		
		$jData['setid'] = $sData['setid'] = $vData['setid'] = $id;
		$SetJuzs->deleteWhere($jData);
		$SetSuras->deleteWhere($jData);
		$SetVerses->deleteWhere($jData);
		
		foreach ($juzs as $r) {
			$jData['juzid'] = $r;
			$SetJuzs->insert($jData);
		}
		
		foreach ($suras as $r) {
			$sData['suraid'] = $r;
			$SetSuras->insert($sData);
		}
		
		$i=0;
		foreach ($fvids as $fvid) {
			$vData['fromverseid'] = $fvid;
			$vData['toverseid'] = $tvids[$i];
			if ($fvid && $tvids[$i]) $SetVerses->insert($vData);
			$i++;
		}
		
		$_SESSION['message'] = 'Set Updated';
		redirectBack();
	}
	
	if ( $action == 'set_delete' ) {
		
		$id = $_GET['id'];
		$Sets->real_delete($id);
		
		$sData['setid'] = $id;
		$SetJuzs->deleteWhere($sData);
		$SetSuras->deleteWhere($sData);
		$SetVerses->deleteWhere($sData);
		
		$_SESSION['message'] = 'Set Deleted';
		redirectBack();
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
	
	if ($action == 'ajax_getAllVerses' ) {
		$search = $_GET['search'];
		
		$verses = $Verses->getVerses($search);
		$response = array();
		
		foreach ($verses as $val=>$row) {
			$obj=null;
			$obj->id=$row['id'];
			$obj->text=$row['text'];
			$response['items'][]=$obj;
		}
		$data['content']=$response;
	}
	
?>