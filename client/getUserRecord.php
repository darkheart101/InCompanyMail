<?php
	require_once("../class/class.database.php");
	require_once("../class/class.Users.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$users = new Users($database);

	$UserID = isset($_REQUEST['UserID'])?$_REQUEST['UserID']:0;


	//Everything went well and you have the email
	$results['data'] = $users->get_UserRecord_ByID($UserID);
	$results['response'] = "success";
	echo json_encode($results);

	return;

?>