<?php

class Email{

	protected $database;

	public function __construct(PDO $db){
		$this->database = $db;
	}

	public function sendEmail($senderID,$receiverID,$msg){

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

		$stmt = $this->database->prepare($query);
		
		$args = array(
			":iduser" => $receiverID
			,":fromID" => $senderID
			,":emailMsg" => $msg
		);

		$stmt->execute($args);

		return true;

	}

	public function receiveEmails($receiverID){

		$query = "
			SELECT
				IFNULL(subject,'No subject') as subject
				,msg
			FROM receivedemails
			WHERE
				iduser = :receiver
		";

		$args = array(
			":receiver" => $receiverID
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		
		$emailsArray = array();

		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){

			array_push($emailsArray,$row);

		}

		return $emailsArray;
	}
	 

}

?>