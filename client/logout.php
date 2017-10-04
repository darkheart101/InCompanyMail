<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");
	session_start();
	session_unset();
	header('Location: http://'.APP_ROOT_URL);


?>