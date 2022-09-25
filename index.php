<?php
	ob_start();
	/* Ya Aba Salehul Mahdi Adrikni */
	/* BUL BAL BUL */
	// error_reporting(E_ALL);
	session_start();
	
	include 'cfg/database.php';
	include 'functions.php';	
	include 'db.php';
	
	
	$controllers = 'controllers/';
	$models = 'models/';
	$default_module = 'home';
	$default_action = 'index';
	$layout = 'layout.tpl.php';
	$pagetitle = 'Quran Teacher';
	
	$module = $_GET['module'];
	$action = $_GET['action'];
	$action = str_replace ( '.html', '', $action );
	$format = $_GET['format'];
		
	
	if ( empty($module) ) $module = $default_module;
	if ( empty($action) ) $action = $default_action;
	
	// validate login of user
	$member = $_SESSION['member'];	
	/* Include all models */
	loadDir($models);
	//Instantiate the classes;
	include 'instantiate.php';

	// --------------------------------		
	$user = $_SESSION['user'];
	if ( !empty($user) ) {
		// Define some global constants
		define('MEMBER_LOGGEDIN',true);
		define('USER_ID',$_SESSION['user']['id']);
	}
	else {
		define('USER_ID','');
	}

    define('TableHead','bg-darkCyan');
    define('TableHeadText','fg-white');
	define('ButtonBkgText','bg-darkCyan fg-white');

	if ( $format == 'json' ) $action = 'ajax_' . $action;

	if(empty($data['message'])) $data['message'] = $_SESSION['message'];
	if(empty($data['error'])) $data['error'] = $_SESSION['error'];
	
	if ( file_exists ( $controllers . $module . '.php' ) ) {
		include $controllers . $module . '.php';
	}

	$data['module'] = $module;
	$data['action'] = $action;
		
	$data['menu'] = loadTemplate('menu.tpl.php', $data);	
	
	if ( empty($data['pagetitle']) ) 	$data['pagetitle'] = $pagetitle;
	if ( empty($data['layout']) ) 	$data['layout'] = $layout;
	
	if ( $format == 'none' ) {
		$data['layout'] = 'layout_iframe.tpl.php';
		
		global $templateData;		
		$data['content'] .= '<script>window.print();</script>';
		$templateData['content'] = $data['content'];
	}
	
	if ( $format == 'json' ) echo json_encode($data['content']);
	else echo loadTemplate($data['layout'], $data);

	if ( $_SESSION['message'] ) $_SESSION['message'] = '';
	if ( $_SESSION['error'] ) $_SESSION['error'] = '';
	
	//AL HAMDU LILLAH;;
	ob_flush();
?>