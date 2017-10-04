<?php
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.email.php");
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

session_start();
$database = Database::getInstance();

//When Not Logged In
if(empty($_SESSION) ){
	header('Location: http://'.APP_ROOT_URL);
}

?>

<html>
	<head>
		<title>InCompanyMail - Main - <?php echo $_SESSION['username']; ?></title>
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
		                    <li><a href="settings.php">Settings</a></li>
		                    <li><a href="./client/logout.php">Logout</a></li>
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
		                <li class="active"><a href="#"><span class="badge pull-right"><?php echo $_SESSION['unreadMails']; ?></span> Inbox </a></li>
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
		                    <table class="table table-striped table-hover">
		                        <tbody>
		                            <!-- inbox header -->
		                            <tr>
		                                <td>
		                                    <label>
		                                        <input type="checkbox" class="all" title="select all">
		                                    </label>
		                                </td>
		                                <td>
		                                    <button class="btn btn-default"><i title="delete selected" class="glyphicon glyphicon-trash"></i></button>
		                                    <button class="btn btn-default"><i title="move to folder" class="glyphicon glyphicon-folder-open"></i></button>
		                                </td>
		                                <td></td>
		                            </tr>
		                            <?php
		                            	
		                            	if($_SESSION['mailsums'] == 0){
		                            		echo '
						                            <tr>
						                                <td>
						                                	<b>You have no emails</b>
						                                </td>
						                            </tr>

						                        ';
		                            	}else{
		                            		$email = new Email($database);
		                            		$receivedEmails = $email->receiveEmails($_SESSION['idusers']);

		                            		foreach ($receivedEmails as $emailRecord ) {
		                            			if($emailRecord['emailStatus'] == 0)
						                            	$unread = 'class="unread"';
						                        else
						                        		$unread = '';

												echo '
					                            	<!-- inbox item -->
						                            <tr  '.
						                            $unread
						                            .' data-id ="'. $emailRecord['idmail'] .'">
						                                <td>
						                                    <label>
						                                        <input type="checkbox">
						                                    </label> <span class="name">'. $emailRecord['senderFullName'].'</span></td>
						                                <td><span class="subject">' . $emailRecord['subject']. '</span> <small class="text-muted"></small></td>
						                                <td></td>
						                            </tr>
			                            		';		                            			
		                            			
		                            		}
		                            	}
		                            ?>
		                        </tbody>
		                    </table>


							<!-- 
							***	START ***
							*	New Email Modal
							*
							 -->
							<div id="myModal" class="modal fade" role="dialog">
								<div class="modal-dialog">

							    
									<div class="modal-content">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal">&times;</button>
							        		<h4 class="modal-title">New Message</h4>
							        		<div  id="error_msg"></div>
							      		</div>
							      		<div class="modal-body">
							      		<form id="sendform">
											<fieldset class="form-group">
												<label for="emailTo">To:</label>
												<input id="emailTo" type="text" name="emailTo">
												<label for="emailTo">Subject:</label>
												<input id="emailSubject" type="text" name="emailSubject">

												<textarea id="emailMsg" class="form-control" name="editstatus" id="editstatus" rows="3"></textarea>
											</fieldset>
											<div class="modal-footer">
												<button id="send" type="submit"  class="btn btn-primary">Send</button>
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												
												<input type="hidden" name="postide" id="postide" value="">
											</div>
										</form>							      		
							    		</div>
							  		</div>
								</div>
							</div>
							<!-- 
							***	END ***
							*	New Email Modal
							*
							 -->

							<!-- 
							***	START ***
							*	Read Email Modal
							*
							 -->
							<div class="modal fade" id="readEmailModal" role="dialog">
								<div id="idmail" class="hidden"></div>
    							<div class="modal-dialog">
    
      								<!-- Modal content-->
									<div class="modal-content">
        								<div class="modal-header">
          									<button type="button" class="close" data-dismiss="modal">&times;</button>
          									<h4 class="modal-title" id="email-subject"></h4>

        								</div>
        								<div class="modal-body">
          									<p  id="mail-body"></p>
        								</div>
        								<div class="modal-footer">
          									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          						            <button type="button" class="btn btn-primary" id="delete-email">Delete</button>
        								</div>
      								</div>
								</div>
  							</div>  							
							<!-- 
							***	END ***
							*	Read Email Modal
							*
							 -->								 							

		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script>
			$('#sendform').submit(function() {
				//Prevent default action
				event.preventDefault();
				
				
				var emailTo 		= $('#emailTo').val();
				var emailMsg 		= $('#emailMsg').val();
				var emailSubject 	= $('#emailSubject').val();

				//Ajax call
				$.ajax({
					url: 'client/sendemail.php',
					type: 'POST',
					data: {emailTo : emailTo, emailMsg : emailMsg, emailSubject: emailSubject},
					dataType:'JSON',
					success: function(resp){
						
						if( resp.response == "success" ){
							
							$("#myModal").modal("hide");
							$('#emailTo').val('') ;
							$('#emailMsg').val('') ;
							$('#emailSubject').val('') ;
						}

						if(resp.response == "fail"){
							$('#error_msg').addClass('alert alert-danger');
							$('#error_msg').html(resp.error_msg);
						}

					}
				});//ajax	 
			})


			//Read email 
			$("tr").click(function(event) {
				//$('#readEmailModal').modal({ show: false})

        		var id = $(this).attr('data-id');	
				//Ajax call
				$.ajax({
					url: 'client/reademail.php',
					type: 'POST',
					data: {idmail : id},
					dataType:'JSON',
					success: function(resp){
						if( resp.response == "success" ){
							$('#readEmailModal').modal('show');
						
							$('h4#email-subject').html(resp.data.subject); // email subject
							$('p#mail-body').html(resp.data.msg); // email body
							$('div#idmail').html(resp.data.idmail); // email id
							
							
						}		
						if(resp.response == "fail"){
							console.log('ERROR');
						}

					}
				});//ajax        		
    		});

			$('#readEmailModal').on('hidden.bs.modal', function () {
			    location.reload();			    
			})

			$("#delete-email").on("click", function(e){
				e.preventDefault(); // prevent de default action, which is to submit

				var idmail = $('#idmail').text();
				//Ajax call
				$.ajax({
					url: 'client/deleteemail.php',
					type: 'POST',
					data: {idmail : idmail},
					dataType:'JSON',
					success: function(resp){
						if( resp.response == "success" ){
							
							
						}		
						if(resp.response == "fail"){
							console.log('ERROR');
						}

					}
				});//ajax
			location.reload();		        
			$(this).prev().click();

			});

			// Clear variables on modal close
			$("#myModal").on("hidden.bs.modal", function () {
			    $('#emailTo').val('') ;
				$('#emailMsg').val('') ;
			});		
			
		</script>
	</body>
</html>