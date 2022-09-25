<?

if ( $action == 'index' ) {
	
	$tData['check'] = $Users->getAll();
	
	$data['content'] = loadTemplate('users.tpl.php',$tData);
}


if ( $action == 'users_edit' ) {
	
	$id = $_GET['id'];
	$tData['user'] = $Users->get($id);
	
	$action = 'users_add';
}

if ( $action == 'users_add') {
	
	$data['content'] = loadTemplate('users_edit.tpl.php',$tData);
}

if ( $action == 'users_save' ) {
	
	$id = intval($_POST['id']);
	$miniData = $_POST['user'];

	if ( empty($id) )  {
		$Users->insert($miniData);
		$id = $Users->lastId();
		
		$_SESSION['message'] = 'User Added';
		redirect('users','users_add');
		
	} else {
		$Users->update($id,$miniData);
		$_SESSION['message'] = 'User Updated';
		redirect('users','users_edit','id='.$id.'');
		
	}
}

if ( $action == 'users_delete' ) {
	
	$Id = $_GET['id'];
	$Users->real_delete($Id);
	
	$_SESSION['message'] = 'User deleted';
	redirect('users','index');
}
