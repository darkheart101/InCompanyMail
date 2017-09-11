<?php
	require_once("../class/class.database.php");
	require_once("../class/class.Users.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$user = new Users($database);

	if( !isset($_POST['username']) OR empty($_POST['username'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No username found";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$username = $_POST['username'];

	if( !isset($_POST['oldPwd']) OR empty($_POST['oldPwd'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No oldPwd found";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$oldPwd = $_POST['oldPwd'];	


	if( !isset($_POST['newPwd']) OR empty($_POST['newPwd'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No newPwd found";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$newPwd = $_POST['newPwd'];	

	
	$results['data'] = $user->update_UserRecord($username, $oldPwd, $newPwd);
	$results['response'] = "success";
	
	if($results['data'] == false){
		$results['response'] = "fail";	
	}

	echo json_encode($results);

	return;

?>