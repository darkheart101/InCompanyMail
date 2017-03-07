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
				,fromid
				,msg
			)
			VALUES
			(
				$receiverID
				,$senderID
				,$msg
			)
		";

		$database->prepare($query)->execute();

		return true;

	}
	 

}

?>