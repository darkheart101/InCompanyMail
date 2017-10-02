<?php
	require_once("../class/class.database.php");
	require_once("../class/class.Users.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$users = new Users($database);

	//Everything went well and you have the email
	$results['data'] = $users->get_UserList();
	$results['response'] = "success";
	echo json_encode($results);

	return;

?>