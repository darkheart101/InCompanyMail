<?php

class Users{

	protected $database;

	public function __construct(PDO $db){
		$this->database = $db;
	}

	// Update User Password
	public function update_UserPassword($username, $oldPwd, $newPwd){

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

		return true;

	}

	// Create new User
	public function insert_new_UserRecord($username, $password){
		$password = md5($password);
		$usermail = $username.'@'.$username.'.icm';




		$query = "
			INSERT INTO users
			(
				username
				,password
				,usermail
			)
			VALUES
			(
				:username
				,:password
				,:usermail
			)
		";
		
		$args = array(
					":username"=>$username
					,":password"=>$password
					,":usermail"=>$usermail
				);
		$stmt = $this->database->prepare($query);
		$stmt->execute($args);

		return true;		
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
	/* Gets User Record by UserID */
	public function get_UserRecord_ByID($UserID){
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
				idusers = :UserID ";

		$args = array(
			":UserID" => $UserID
		);

		$stmt = $this->database->prepare($query);
		$stmt->execute($args);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);



		return $row;				
	}
	/* user List */

	public  function get_UserList(){
		$query = "
			SELECT
				idusers
			    ,username
			    ,usermail
			    ,lastname
			    ,name
			FROM icmail.users
		";

		$stmt = $this->database->prepare($query);
		$stmt->execute();
		
		$userArray = array();

		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){

			$row['UserFullName'] = $row['lastname'] . ' '.$row['name'];
			array_push($userArray,$row);

		}

		return $userArray;		
	}

	public  function update_UserRecord($params,$UserID){

		$name = "";
		
		if(isset($params['name']) ){
			$name = $params['name'];
		}

		$lastname = "";
		if(isset($params['lastname']) ){
			$lastname = $params['lastname'];
		}

		$usermail = "";
		if(isset($params['usermail']) ){
			$usermail = $params['usermail'];
		}

		$query = "
			UPDATE users SET
				lastname 	= :lastname
				,name 		= :name
				,usermail 	= :usermail
			WHERE
				idusers = :UserID
		";

		$args = array(
			":lastname" => $lastname
			,":name" => $name
			,":usermail" => $usermail
			,":UserID" => $UserID
		);
		$stmt = $this->database->prepare($query);
		$stmt->execute($args);		

		return true;

	}
	 

}

?>