<?php
	require_once("class.database.php");

	$database = Database::getInstance();
	
	if( !isset($_POST['name']) OR empty($_POST['name'])){
		$results['response'] = "fail";
		$results = json_encode($results);
		echo $results;
		return;
	}

	if( !isset($_POST['pass']) OR empty($_POST['pass'])){
		$results['response'] = "fail";
		$results = json_encode($results);
		echo $results;
		return;
	}	

	$username = trim($_POST['name']);
	$password = trim($_POST['pass']);

	$password = md5($password);

	$stmt = $database->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
	$args = array(
		":username" => $username
		,":password" => $password
	);
	$stmt->execute($args);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$count = $stmt->rowCount();
	
	if($count == 1){
		$results['response'] = "success";
		
		echo json_encode($results);
		return;	
	}else{

		$results['response'] = "fail";
		echo json_encode($results);
		return;
	}		



?>