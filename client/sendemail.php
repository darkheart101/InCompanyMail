<?php
	require_once("../class/class.database.php");
	require_once("../class/class.email.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$email = new Email($database);

	if( !isset($_POST['emailTo']) OR empty($_POST['emailTo'])){
		$results['response'] = "fail";
		$results['error_msg'] = "Fill out the email";
		$results = json_encode($results);
		echo $results;
		return;
	}	

	if( !isset($_POST['emailMsg']) OR empty($_POST['emailMsg'])){
		$results['response'] = "fail";
		$results['error_msg'] = "Fill out your message";
		$results = json_encode($results);
		echo $results;
		return;
	}

	$emailMsg = $_POST['emailMsg'];
	$emailTo = $_POST['emailTo'];

	// Get UserID of the Receiver
	$query = "
		SELECT
			idusers
		FROM users
		WHERE
			usermail = :emailTo
	";

	$args = array(
			":emailTo" => $emailTo
		);
	
	$stmt = $database->prepare($query);
		
	$stmt->execute($args);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	// If email not exist return
	if( !isset($row['idusers']) ){
		$results['response'] = "fail";
		$results['error_msg'] = "This Email Does Not Exist";
		$results = json_encode($results);
		echo $results;
		return;
	}

	$iduser = $row['idusers']; // Receiver UserID

	$fromID = $_SESSION['idusers']; // Sender UserID

	/************************************************/
	/* 					START						*/
	/* 			CREATE THE NEW EMAIL				*/
	/* 												*/
	/************************************************/
	$query = "
		INSERT INTO receivedemails
		(
			iduser
			,fromID
			,msg
		)
		VALUES
		(	
			:iduser
			,:fromID
			,:emailMsg
		)
	";

	$stmt = $database->prepare($query);
	
	$args = array(
		":iduser" => $emailTo
		,":fromID" => $fromID
		,":emailMsg" => $emailMsg
	);

	$stmt->execute($args);

	/************************************************/
	/* 					END 						*/
	/* 			CREATE THE NEW EMAIL				*/
	/* 												*/
	/************************************************/

	//Everything went well
	$results['response'] = "success";
	echo json_encode($results);

	return;

?>