<?

	if ( $action == 'index' ) {
		
		$tData['sets'] = $Sets->getAll();
		
		$data['content'] = loadTemplate('home.tpl.php',$tData);
	}
	
	if ( $action == 'home_content' ) {
	
		$id = $_GET['id'];
		$data['layout'] = 'layout_iframe.tpl.php';
		
		$tData['set'] = $Sets->getDetails($id);
		$tData['suras'] = $SetSuras->search($id);
		$tData['juzs'] = $SetJuzs->search($id);
		$tData['verses'] = $SetVerses->search($id);
		
		$data['content'] = loadTemplate('home_content.tpl.php',$tData);
	}
	
	if ($action == 'ajax_getVerses' ) {
		$jids = $_GET['jids'];
		$sids = $_GET['sids'];
		$svids = $_GET['svids'];
		
		$verses = $SetVerses->getVerses($jids,$sids,$svids);
		$response = array();
		
		foreach ($verses as $val=>$row) {
			$obj=null;
			$obj->id=$row['id'];
			$obj->text=$row['text'];
			$obj->vno=$row['vno'];
			$obj->sno=$row['sno'];
			$obj->sura=$row['sura'];
			$response[]=$obj;
		}
		$data['content']=$response;
	}
	
?>