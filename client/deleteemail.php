<?php
	require_once("../class/class.database.php");
	require_once("../class/class.email.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$email = new Email($database);

	if( !isset($_POST['idmail']) OR empty($_POST['idmail'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No mail to read";
		$results = json_encode($results);
		echo $results;
		return;
	}	
	$idmail = $_POST['idmail'];

	//Everything went well and you have the email
	$results['data'] = $email->deleteEmail($idmail);
	$results['response'] = "success";
	echo json_encode($results);

	return;

?>