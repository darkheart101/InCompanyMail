<?php
	require_once("../class/class.database.php");
	require_once("../class/class.email.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");


	//Make database connection
	$database = Database::getInstance();

	$email = new Email($database);


?>