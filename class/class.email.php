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
	 

}

?>