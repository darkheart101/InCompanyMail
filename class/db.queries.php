<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.database.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");
	session_start();


		$db_name = DB_NAME;

		$database = Database::getInstance();
			
		$query = "

			CREATE TABLE  IF NOT EXISTS  `$db_name`.`users` (
				`idusers` INT NOT NULL,
				`username` VARCHAR(45) NULL,
				`password` VARCHAR(45) NULL,
				PRIMARY KEY (`idusers`)
			);

			INSERT INTO users(
				username
				,password
			)VALUES('admin', MD5('admin'))
		";

		$database->prepare($query)->execute();
		
		if($_SESSION['idusers'] == 0){
			$query = "
				SELECT 
					IFNULL(column_name, '') INTO @colName
				FROM information_schema.columns 
				WHERE table_name = 'users'
				AND column_name = 'usermail';

				IF @colName = '' THEN 
					ALTER TABLE users ADD usermail VARCHAR(50) NOT NULL
				END IF;	
			";

			$database->prepare($query)->execute();	

			$query = "
				SELECT 
					IFNULL(usermail, '') INTO @adminMail
				FROM users
				WHERE idusers = 0;
				
				IF @adminMail = '' THEN
					BEGIN
					UPDATE users SET
						usermail = 'admin@admin.icm'
					WHERE idusers = 0
					END
				END IF
			";

			$database->prepare($query)->execute();

			$query = "
				CREATE TABLE  IF NOT EXISTS  `$db_name`.`ReceivedEmails` (
					`idmail` INT NOT NULL AUTO_INCREMENT,
					`iduser` INT NOT NULL,
					`fromID` INT NOT NULL,
					`msg` VARCHAR(255) NULL,
					PRIMARY KEY (`idmail`)
				);
			";

			$database->prepare($query)->execute();


			$query = "
				ALTER TABLE `$db_name`.`ReceivedEmails`
				ADD subject VARCHAR(255) NULL;
			";		

			$database->prepare($query)->execute();


			echo "<h1>Database changes ready</h1>";		
		
		}else{
			echo "You have no access";
		}
	

?>