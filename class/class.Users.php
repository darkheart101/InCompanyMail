<?php

class Users{

	protected $database;

	public function __construct(PDO $db){
		$this->database = $db;
	}

	public function update_UserRecord($username, $oldPwd, $newPwd){

		$ret = $this->get_UserRecord($username);

		if( md5($oldPwd) != $ret['password'] ){
			return false;
		}

		$newPwd = md5($newPwd);

		$query = "
			UPDATE users SET
				password = :newPwd
			WHERE
				username = :username
		";

		$args = array(
			":newPwd" => $newPwd
			,":username" => $username
		);
		$stmt = $this->database->prepare($query);
		$stmt->execute($args);		

	}

	/* Gets User Record by Username */
	public function get_UserRecord($username){
		$query = "
			SELECT
				idusers
				,username
				,password
				,usermail
				,lastname
				,name
			FROM users
			WHERE
				username = :username ";

		$args = array(
			":username" => $username
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);



		return $row;				
	}


	 

}

?>