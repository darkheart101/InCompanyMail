<?php
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.email.php");


session_start();
$database = Database::getInstance();
?>

<html>
	<head>
		<title>InCompanyMail - Settings - <?php echo $_SESSION['username']; ?></title>
		<link rel="stylesheet" href="./resources/css/main.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>	
	<body>
		<div class="container-fluid">
		    <div class="row">
		        <div class="col-sm-3 col-md-2">
		            <div class="btn-group">
		                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		                    <?php echo $_SESSION['usermail']; ?> <span class="caret"></span>
		                </button>
		                <ul class="dropdown-menu" role="menu">
		                    <li><a href="main.php">Mail</a></li>
		                    <!--
		                    <li><a href="#">Contacts</a></li>
		                    <li><a href="#">Tasks</a></li>
		                    -->
		                </ul>
		            </div>
		        </div>
		        <div class="col-sm-9 col-md-10">
		            <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh"  onClick="window.location.reload()" >
		                <span class="glyphicon glyphicon-refresh"></span> </button>
		            <div class="btn-group">
		                <ul class="dropdown-menu" role="menu">
		                    <li><a href="#">Mark all as read</a></li>
		                    <li class="divider"></li>
		                    <li class="text-center"><small class="text-muted">Select messages to see more actions</small></li>
		                </ul>
		            </div>
		            <div class="pull-right">
		                <span class="text-muted"><b>1</b>–<b>50</b> of <b>160</b></span>
		                <div class="btn-group btn-group-sm">
		                    <button type="button" class="btn btn-default">
		                        <span class="glyphicon glyphicon-chevron-left"></span>
		                    </button>
		                    <button type="button" class="btn btn-default">
		                        <span class="glyphicon glyphicon-chevron-right"></span>
		                    </button>
		                </div>
		            </div>
		        </div>
		    </div>
		    <hr>
		    <div class="row">
		        <!--left-->
		        <aside class="col-sm-3 col-md-2">
		            <button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-edit"></i> Compose</button>
		            <hr>
		            <ul class="nav nav-pills nav-stacked">
		                <li class="active"><a href="main.php"><span class="badge pull-right"><?php echo $_SESSION['unreadMails']; ?></span> Inbox </a></li>
		                <li><a href="#">Archived</a></li>
		                <li><a href="#">Important</a></li>
		                <li><a href="#">Sent</a></li>
		                <li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>
		            </ul>
		            <hr>

		        </aside>
		        <!--main-->
		        <div class="col-sm-9 col-md-10">
		            <!-- tab panes -->
		            <div class="tab-content">
		                <div class="tab-pane fade in active" id="inbox">
		                    <h2>Change Your Password</h2>
							<form id="savePwd"action="" method="post">
								<input type="text" name="username" hidden value='<?php echo $_SESSION['username'] ?>' />
								Old Password:<br>
								<input type="text" name="oldpassword">
								<br>
								New Password:<br>
						  		<input type="text" name="newpassword">
						  		<br><br>
								Retype New Password:<br>
						  		<input type="text" name="newpasswordretyped">
						  		<br><br>						  		
						  		<input type="submit" value="Save">
							</form> 
							<hr>
							<?php
								if( $_SESSION['idusers'] == 0){ // Options only for administrator
							?>
								<h2>Create New User</h2>
								<form id="newUser"action="" method="post">
									
									Username:<br>
									<input type="text" name="newUsername">
									<br>									
									Password:<br>
							  		<input type="text" name="newUserPassword">
							  		<br><br>
									Retype New Password:<br>
							  		<input type="text" name="newUserPasswordRetyped">
							  		<br><br>						  		
							  		<input type="submit" value="Save">
								</form> 
							<?php
								}
							?>
							
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script>
			$('#savePwd').submit(function() {
				//Prevent default action
				event.preventDefault();

				var username 	= $('[name=username]').val();
				var oldpwd 		= $('[name=oldpassword]').val();
				var newpwd 		= $('[name=newpassword]').val();
				var renewpwd 	= $('[name=newpasswordretyped]').val();


				if( newpwd.localeCompare(renewpwd) == -1){

					alert("Password mismatch!!!");
					return;
				}
				


				//Ajax call
				$.ajax({
					url: 'client/changePassword.php',
					type: 'POST',
					data: {username: username, oldPwd : oldpwd, newPwd : newpwd},
					dataType:'JSON',
					success: function(resp){
						
						if( resp.response == "success" ){
							alert("Password changed successfully");
							
						}

						if(resp.response == "fail"){
							alert("Password Error");
						}

					}
				});//ajax	

			})


			// Create new User
			$('#newUser').submit(function() {
				//Prevent default action
				event.preventDefault();


				var newUsername 			= $('[name=newUsername]').val();
				var newUserPassword 		= $('[name=newUserPassword]').val();
				var newUserPasswordRetyped 	= $('[name=newUserPasswordRetyped]').val();


				if( newUserPassword.localeCompare(newUserPasswordRetyped) == -1){

					alert("Password missmatch!!!");
					return;
				}
				


				//Ajax call
				$.ajax({
					url: 'client/createNewUser.php',
					type: 'POST',
					data: {username: newUsername, password : newUserPassword},
					dataType:'JSON',
					success: function(resp){
						
						if( resp.response == "success" ){
							alert("New user Created");
							
						}

						if(resp.response == "fail"){
							alert("User Creation Error!");
						}

					}
				});//ajax	

			})			
			
		</script>
	</body>
</html>