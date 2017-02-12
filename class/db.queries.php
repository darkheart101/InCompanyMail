<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class.database.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");
	
	$db_name = DB_NAME;

	$database = Database::getInstance();
	
	$query = "

		CREATE TABLE  IF NOT EXISTS  `$db_name`.`users` (
			`idusers` INT NOT NULL,
			`username` VARCHAR(45) NULL,
			`password` VARCHAR(45) NULL,
			PRIMARY KEY (`idusers`)
		);

		INSERT INTO users(
			username
			,password
		)VALUES('admin', MD5('admin'))
	";

	$database->prepare($query)->execute();

	echo "<h1>Database changes ready</h1>";

?>