<?php
	require_once("class.database.php");

	$database = new Database();

	$link = $database->connect();
	
	$query = "
		CREATE TABLE `icmail`.`users` (
		  `idusers` INT NOT NULL,
		  `username` VARCHAR(45) NULL,
		  `password` VARCHAR(45) NULL,
		  PRIMARY KEY (`idusers`));
	";

	$link->prepare($query)->execute();

	echo "<h1>Database changes ready</h1>";

?>