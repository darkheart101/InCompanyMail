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

	if( !isset($_POST['password']) OR empty($_POST['password'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No password found";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$password = $_POST['password'];

	
	$results['data'] = $user->insert_new_UserRecord($username, $password);

	$results['response'] = "success";

	if( $results['data'] == false){
		$results['response'] = "fail";	
	}

	echo json_encode($results);

	return;

?>