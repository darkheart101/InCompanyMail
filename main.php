<?php
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/class/class.email.php");


session_start();
$database = Database::getInstance();
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
		                    <li><a href="#">Mail</a></li>
		                    <li><a href="#">Contacts</a></li>
		                    <li><a href="#">Tasks</a></li>
		                </ul>
		            </div>
		        </div>
		        <div class="col-sm-9 col-md-10">
		            <!--
		            <div class="btn-group">
		                <button type="button" class="btn btn-default">
		                    <input type="checkbox" aria-label="..." style="margin:1px;">
		                </button>
		                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		                    <span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
		                </button>
		                <ul class="dropdown-menu" role="menu">
		                    <li><a href="#">All</a></li>
		                    <li><a href="#">None</a></li>
		                    <li><a href="#">Read</a></li>
		                    <li><a href="#">Unread</a></li>
		                    <li><a href="#">Starred</a></li>
		                    <li><a href="#">Unstarred</a></li>
		                </ul>
		            </div>
		            -->
		            <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh">
		                <span class="glyphicon glyphicon-refresh"></span> </button>
		            <div class="btn-group">
		                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		                    More <span class="caret"></span>
		                </button>
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
		            <!--<a href="#" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-edit"></i> Compose</a>-->
		            <button type="button" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#myModal"><i class="glyphicon glyphicon-edit"></i> Compose</button>
		            <hr>
		            <ul class="nav nav-pills nav-stacked">
		                <li class="active"><a href="#"><span class="badge pull-right">32</span> Inbox </a></li>
		                <li><a href="#">Archived</a></li>
		                <li><a href="#">Important</a></li>
		                <li><a href="#">Sent</a></li>
		                <li><a href="#"><span class="badge pull-right">3</span>Drafts</a></li>
		            </ul>
		            <hr>
		            <div class="storage">
		                <small>2.85 GB of <strong>15 GB</strong></small>
		                <div class="progress progress-sm">
		                    <div class="progress-bar progress-bar-primary" style="width:30%;"></div>
		                </div>
		            </div>
		        </aside>
		        <!--main-->
		        <div class="col-sm-9 col-md-10">
		            <!-- tabs -->
		            <ul class="nav nav-tabs">
		                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
		                </span>Primary</a></li>
		                <li><a href="#profile" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
		                    Personal</a></li>
		                <li><a href="#settings" data-toggle="tab"><span class="glyphicon glyphicon-plus no-margin">
		                </span></a></li>
		            </ul>
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
												echo '
					                            	<!-- inbox item -->
						                            <tr>
						                                <td>
						                                    <label>
						                                        <input type="checkbox">
						                                    </label> <span class="name">Mark Otto</span></td>
						                                <td><span class="subject">' . $emailRecord['subject']. '</span> <small class="text-muted">- Joe, I just reviewed the last...</small></td>
						                                <td><span class="badge">12:10 AM</span> <span class="pull-right glyphicon glyphicon-paperclip"></span></td>
						                            </tr>
			                            		';		                            			
		                            			
		                            		}
			                            	
			                       		                            		
		                            	}

		                            ?>
	
		                            <!-- inbox item -->
		                            <!--<tr>
		                                <td>
		                                    <label>
		                                        <input type="checkbox">
		                                    </label> <span class="name">Anil Judah</span></td>
		                                <td><span class="subject">GAE Project</span> <small class="text-muted">- Can you take a second to look..</small></td>
		                                <td><span class="badge badge-inverse">11:33 AM</span> <span class="pull-right glyphicon glyphicon-warning-sign text-danger"></span></td>
		                            </tr>
		                            <tr class="unread">
		                                <td>
		                                    <label>
		                                        <input type="checkbox">
		                                    </label> <span class="name">Terry Lincoln</span></td>
		                                <td><span class="subject">Vacation pics</span> <small class="text-muted">(this message contains images)</small></td>
		                                <td><span class="badge">11:13 AM</span> <span class="pull-right"></span></td>
		                            </tr>
		                            <tr>
		                                <td>
		                                    <label>
		                                        <input type="checkbox">
		                                    </label> <span class="name">Mark Brown</span></td>
		                                <td><span class="subject">Last call for this weekend</span> <small class="text-muted">- Hi Joe, Thanks for sending over those..</small></td>
		                                <td><span class="badge">11:05 AM</span> <span class="pull-right"></span></td>
		                            </tr>
		                            <tr>
		                                <td>
		                                    <label>
		                                        <input type="checkbox">
		                                    </label> <span class="name">Jorge Anodonolgez</span></td>
		                                <td><span class="subject">Meeting with Simco</span> <small class="text-muted">- Joe I included your contact info for the...</small></td>
		                                <td><span class="badge">10:54 AM</span> <span class="pull-right glyphicon glyphicon-paperclip"></span></td>
		                            </tr>
		                            <tr>
		                                <td>
		                                    <label>
		                                        <input type="checkbox">
		                                    </label> <span class="name">Mark Otto</span></td>
		                                <td><span class="subject">FYI: New Release</span> <small class="text-muted">this message is high priority</small></td>
		                                <td><span class="badge">9:58 AM</span> <span class="pull-right"></span></td>
		                            </tr>
		                            -->
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
							<!-- 
							***	END ***
							*	New Email Modal
							*
							 -->							

		                </div>
		                <div class="tab-pane fade in" id="profile">
		                    <div class="list-group">
		                        <div class="list-group-item">
		                            <span class="text-center">This tab folder is empty.</span>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="row-md-12">

		                <div class="well text-right">
		                    <small>Last updated: 4/14/2015: 3:02 PM</small>
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
				
				
				var emailTo = $('#emailTo').val();
				var emailMsg = $('#emailMsg').val();

				//Ajax call
				$.ajax({
					url: 'client/sendemail.php',
					type: 'POST',
					data: {emailTo : emailTo, emailMsg : emailMsg},
					dataType:'JSON',
					success: function(resp){
						
						if( resp.response == "success" ){
							
							$("#myModal").modal("hide");
							$('#emailTo').val('') ;
							$('#emailMsg').val('') ;
						}

						if(resp.response == "fail"){
							$('#error_msg').addClass('alert alert-danger');
							$('#error_msg').html(resp.error_msg);
						}

					}
				});//ajax	 
			})

			// Clear variables on modal close
			$("#myModal").on("hidden.bs.modal", function () {
			    $('#emailTo').val('') ;
				$('#emailMsg').val('') ;
			});			
		</script>
	</body>
</html>