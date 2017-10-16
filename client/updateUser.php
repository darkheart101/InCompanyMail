<?php
	require_once("../class/class.database.php");
	require_once("../class/class.Users.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$user = new Users($database);

	if( !isset($_POST['UserID']) OR empty($_POST['UserID'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No UserID found";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$UserID = $_POST['UserID'];

	$params = array();

	if( isset($_POST['lastname']) ){
		$params['lastname'] = $_POST['lastname'];
	}

	if( isset($_POST['name']) ){
		$params['name'] = $_POST['name'];
	}

	if( isset($_POST['usermail']) ){
		$params['usermail'] = $_POST['usermail'];
	}

	
	$results['data'] = $user->update_UserRecord($params,$UserID);

	$results['response'] = "success";

	if( $results['data'] == false){
		$results['response'] = "fail";	
	}

	echo json_encode($results);

	return;

?>