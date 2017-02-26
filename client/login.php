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

		//START SESSION
		session_start();

		//Get values from db for the user
		$query = "
			SELECT
				idusers
				,username
				,usermail
			FROM
				users
			WHERE
				username = :username
				AND
				password= :password
		";

		$args = array(
			":username" => $username
			,":password" => $password
		);
		$stmt = $database->prepare($query);
		
		$stmt->execute($args);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//Give SESSION values
		$_SESSION['username'] 	= $row['username'];
		$_SESSION['usermail'] 	= $row['usermail'];
		$_SESSION['idusers'] 	= $row['idusers'];

		//***********************************
		// START - Check the number of emails
		//***********************************

		$query = "
			SELECT
				COUNT(idmail) as mailsums
			FROM
				receivedemails
			WHERE
				iduser = :iduser
		";
		$stmt = $database->prepare($query);

		$args = array(
			":iduser" => $_SESSION['idusers']
		);

		$stmt->execute($args);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$_SESSION['mailsums'] = $row['mailsums'];

		//*********************************
		// END - Check the number of emails
		//*********************************

			
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