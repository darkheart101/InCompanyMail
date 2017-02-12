<?php
	require_once("../class/class.database.php");

	//Make database connection
	$database = Database::getInstance();
	
	//Check if username and password are sent
	if( !isset($_POST['name']) OR empty($_POST['name'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No username";
		$results = json_encode($results);
		echo $results;
		return;
	}

	if( !isset($_POST['pass']) OR empty($_POST['pass'])){
		$results['response'] = "fail";
		$results['error_msg'] = "No Password";
		$results = json_encode($results);
		echo $results;
		return;
	}	

	$username = trim($_POST['name']);
	$password = trim($_POST['pass']);

	//database uses md5 for password
	$password = md5($password);

	//Make the query to the database
	$stmt = $database->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
	
	$args = array(
		":username" => $username
		,":password" => $password
	);

	$stmt->execute($args);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$count = $stmt->rowCount();
	
	if($count == 1){ 
		//when username and password are correct
		$results['response'] = "success";
		
		echo json_encode($results);
		return;	
	
	}else{
		//Username and password wrong
		$results['error_msg'] = "Wrong Username or Password";
		$results['response'] = "fail";
		echo json_encode($results);
		return;
	}		



?>