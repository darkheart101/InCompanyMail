<?php
	require_once("../class/class.database.php");
	require_once("../class/class.email.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");


	//Make database connection
	$database = Database::getInstance();

	$email = new Email($database);

	if( !isset($_POST['emailTo']) OR empty($_POST['emailTo'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No username";
		$results = json_encode($results);
		echo $results;
		return;
	}	

	if( !isset($_POST['emailMsg']) OR empty($_POST['emailMsg'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No username";
		$results = json_encode($results);
		echo $results;
		return;
	}

	$emailMsg = $_POST['emailMsg'];
	$emailTo = $_POST['emailTo'];

	echo $emailMsg;
	echo $emailTo;

	exit();

?>