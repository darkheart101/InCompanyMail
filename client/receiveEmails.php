<?php
	require_once("../class/class.database.php");
	require_once("../class/class.email.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/incompanymail/config.php");

	//Start Session
	session_start();

	//Make database connection
	$database = Database::getInstance();

	$email = new Email($database);

	$results['data'] = '';

	if($_SESSION['mailsums'] == 0){
		                            		$results['data'] = '
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

												$results['data'] .= '
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
	//Everything went well
	$results['response'] = "success";
	echo json_encode($results);

	return;

?>