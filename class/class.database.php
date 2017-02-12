<?php
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

class Database{

	protected static $db;
	 
	//private construct - class cannot be instatiated externally.
	private function __construct() {

		try {
		
			self::$db = new PDO( 'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS );
			self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		
		}catch (PDOException $e) {
			
			echo "Connection Error: " . $e->getMessage();
		}
	 
	}
	 

	public static function getInstance() {
		 
		if (!self::$db) {
			//new connection object.
			new Database();
		}
		 
		//return connection.
		return self::$db;
	}	

}

?>