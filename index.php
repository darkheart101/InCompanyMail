<?php

require_once("class.database.php");

$database = Database::getInstance();

?>
<!DOCTYPE html>
<html >
	<head>
		<meta charset="UTF-8">
		<title>Log-in</title>
  		<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
      	<link rel="stylesheet" href="./resources/css/signin.css">
	</head>

	<body>
	
		<div class="login-card">
			<h1>Log-in</h1><br>
		 	<form id="loginform">
		    	<input type="text" name="user" id="name" placeholder="Username">
		    	<input type="password" name="pass" id="pass" placeholder="Password">
		    	<input type="submit" name="login" class="login login-submit" id="login-button" value="login">
		  	</form>
		    
		  	<div class="login-help">
		    	<a href="#">Register</a> • <a href="#">Forgot Password</a>
		 	</div>
		</div>
		<div id="content"></div>
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
		<script>
			$('#loginform').submit(function() {
				event.preventDefault();
				
				var name = $('#name').val();
				var pass = $('#pass').val();
				
				$.ajax({
					url: 'login.php',
					type: 'POST',
					data: {name : name, pass : pass},
					dataType:'JSON',
					success: function(resp){
						if( resp.response == "success" ){	
							$("#content").html('<img src="resources/img/loader.gif" /> &nbsp; Signing In ...');
							setTimeout(' window.location.href = "test.php"; ',2000);
						}

						if(resp.response == "fail"){
							$('#content').html("<h1>WRONG USERNAME OR PASSWORD</h1>");
						}

					}
				}).error(function(){
					alert('An Error occured!');
				})
			})
		</script>
  
	</body>
</html>

