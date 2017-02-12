<?php
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.database.php");

$database = Database::getInstance();

?>
<!DOCTYPE html>
<html >
	<head>
		<meta charset="UTF-8">
		<title>InCompanyMail Log-in</title>
  		<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  		<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
      	<link rel="stylesheet" href="./resources/css/signin.css">
	</head>

	<body>
	
		<div class="login-card">
			<h1>InCompanyMail Log-in</h1><br>
		 	<form id="loginform">
		 		<div  id="error_msg"></div>
		    	<input type="text" name="user" id="name" placeholder="Username">
		    	<input type="password" name="pass" id="pass" placeholder="Password">
		    	<input type="submit" name="login" class="login login-submit" id="login-button" value="login">
		  	</form>
		    
		  	<div class="login-help">
		    	<a href="#">Register</a> • <a href="#">Forgot Password</a>
		 	</div>
		</div>
		
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
		<script>
			$('#loginform').submit(function() {
				//Prevent default action
				event.preventDefault();
				
				//Get the username and password values
				var name = $('#name').val();
				var pass = $('#pass').val();
				
				//Ajax call
				$.ajax({
					url: 'client/login.php',
					type: 'POST',
					data: {name : name, pass : pass},
					dataType:'JSON',
					success: function(resp){

						//if username and password are correct
						if( resp.response == "success" ){
							$('#error_msg').removeClass('alert alert-danger');	
							$('#error_msg').addClass('alert alert-success');
							$("#error_msg").html('<img src="resources/img/loader.gif" /> &nbsp; Signing In ...');
							setTimeout(' window.location.href = "main.php"; ',4000);
						}
						//If username and password fails
						if(resp.response == "fail"){
							$('#error_msg').addClass('alert alert-danger');
							$('#error_msg').html(resp.error_msg);
						}

					}
				})//ajax
				.error(function(){
					//When everything fails
					alert('An Error occured!');
				});//error
			})
		</script>
  
	</body>
</html>

