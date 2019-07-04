<?php
//require handler
require_once('GuestHandler.php');
require_once('AdminHandler.php');

$method = $_SERVER['REQUEST_METHOD'];
$params = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$controller = $params[0];
$input=$_REQUEST;
if(empty($input)){
	$input = json_decode(file_get_contents('php://input'),true);
}
$queryStr = $_SERVER['QUERY_STRING'];

 switch ($controller){
	// route[/api/user]
	case 'guest':
		//to-do handler
	 	$guestHandler = new GuestHandler($method,$params,$input);
	 	echo $guestHandler->response();
		break;
	case 'admin':
		$adminHandler = new AdminHandler($method,$params,$input);
		echo $adminHandler->response();
		break;
	default:
		header("http/ 404");
		echo 'URL Error!';
 }

?>