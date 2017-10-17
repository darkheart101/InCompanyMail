<?php

class Email{

	protected $database;


	/************************************************************
	* Constructor
	*************************************************************/
	public function __construct(PDO $db){
		$this->database = $db;
	}

	/************************************************************
	* Send Email Function
	*************************************************************/
	public function sendEmail($senderID,$receiverID,$msg,$Subject){

		$query = "
			INSERT INTO receivedemails
			(
				iduser
				,fromID
				,msg
				,subject
			)
			VALUES
			(	
				:iduser
				,:fromID
				,:emailMsg
				,:subject
			)
		";

		$stmt = $this->database->prepare($query);
		
		$args = array(
			":iduser" => $receiverID
			,":fromID" => $senderID
			,":emailMsg" => $msg
			,":subject" => $Subject
		);

		$stmt->execute($args);

		return true;

	}

	/************************************************************
	* Receive Email Function
	*************************************************************/
	public function receiveEmails($receiverID){

		$query = "
			SELECT
				idmail
				,IFNULL(subject,'No subject') as subject
				,msg
				,IFNULL(emailStatus,0) as emailStatus
				,IFNULL(name,' - ') as name
				,IFNULL(lastname,' - ') as lastname
			FROM receivedemails
			LEFT JOIN users ON (idusers = fromID)
			WHERE
				iduser = :receiver
			ORDER BY idmail DESC
		";

		$args = array(
			":receiver" => $receiverID
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		
		$emailsArray = array();

		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){

			$row['senderFullName'] = $row['lastname'] . ' '.$row['name'];
			array_push($emailsArray,$row);

		}

		return $emailsArray;
	}

	/************************************************************
	* Read Email Function
	*************************************************************/
	public function readEmail($idmail){

		$query = "
			SELECT
				idmail
				,IFNULL(subject,'No subject') as subject
				,msg
				,IFNULL(name,' - ') as name
				,IFNULL(lastname,' - ') as lastname
				,IFNULL(emailStatus,0) as emailStatus
			FROM receivedemails
			LEFT JOIN users ON (idusers = fromID)
			WHERE
				idmail = :idmail
		";

		$args = array(
			":idmail" => $idmail
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if( !empty($row) AND ($row['emailStatus'] == 0) ){
			$query = "
				UPDATE receivedemails SET
					emailStatus = 1
				WHERE
					idmail = :idmail
			";
			$args = array(
				":idmail" => $idmail
			);

			$stmt = $this->database->prepare($query);
			$stmt->execute($args);			
		}

		$row['senderFullName'] = $row['lastname'] . ' '.$row['name'];		

		return $row;
	}

	/************************************************************
	* Delete Email Function
	*************************************************************/
	public function deleteEmail($idmail){

		$query = "
			DELETE FROM receivedemails WHERE idmail = :idmail
		";

		$args = array(
			":idmail" => $idmail
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		

		return;
	}			
	 

}

?>