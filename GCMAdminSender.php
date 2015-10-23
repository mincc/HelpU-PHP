<?php
	include_once './GCM.php';

	//this block is to post message to GCM on-click
	$pushStatus = "";	
	if(!empty($_GET["push"])) {	
		$RegIdArray = include 'UserGetAllRegID.php';
		
		foreach($data as $row)
		{
// 			echo 'RegId : ' . $row['gcmRegId'];
// 			echo "<br>";
			
			$gcmRegID  = $row['gcmRegId'];
			$pushMessage = $_POST["message"];	
			
			if (isset($gcmRegID) && isset($pushMessage)) {		
				$gcmRegIds = array($gcmRegID);
				$message = array("message" => $pushMessage, "notificationType" => "Multicast");	
				$gcm = new GCM();
				$pushStatus = $gcm->sendPushNotification($gcmRegIds, $message);
			}	
		}
	}
	
?>
<html>
    <head>
        <title>Google Cloud Messaging (GCM) Server</title>
    </head>
	<body>
		<h1>Google Cloud Messaging (GCM) Server</h1>	
		<form method="post" action="GCMAdminSender.php/?push=1">					                             
			<div>                                
				<textarea rows="10" name="message" cols="100" placeholder="Message to transmit via GCM"></textarea>
			</div>
			<br/><br/>
			<div><input type="submit"  value="Send Push Notification via GCM" /></div>
		</form>
		<p><h3><?php echo $pushStatus; ?></h3></p>
    </body>
</html>