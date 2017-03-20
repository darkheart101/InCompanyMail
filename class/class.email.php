<?php

class Email{

	protected $database;

	public function __construct(PDO $db){
		$this->database = $db;
	}

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

	public function receiveEmails($receiverID){

		$query = "
			SELECT
				IFNULL(subject,'No subject') as subject
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
	 

}

?>