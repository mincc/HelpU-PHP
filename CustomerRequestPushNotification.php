<?php
/*
 * 	21-10-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	include 'ProjectStatus.php';
	include_once './GCM.php';
	
// 	if(!$debug){
//     	$customerRequestId = $_POST["customerRequestId"];
// 	}else{
		$customerRequestId = 149;
// 	}
	
	$sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId, ".
			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
    		"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
			"FROM customerrequest cr ".
			"INNER JOIN user u ON cr.userId = u.userId ".
			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.customerRequestId = ? ";
    
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $customerRequestId);
	$stmt->execute();
	$stmt->store_result();
	$customerRequestData = fetchRow($stmt);
	$projectStatusId = $customerRequestData['projectStatusId'];
	$serviceProviderId = $customerRequestData['serviceProviderId'];
	$customerUserId = $customerRequestData['userId'];
	$isPushNotificationTrigger = 'false'; 
	$userId = 0;
	$regId = "";
	$info = "";
	
	if(	$projectStatusId == ProjectStatus::$Pick->getCode() ||
		$projectStatusId == ProjectStatus::$Deal->getCode() ||
		$projectStatusId == ProjectStatus::$ServiceDone->getCode() ||
		$projectStatusId == ProjectStatus::$CustomerRating->getCode() ){
		
			$sql = 	"SELECT sp.userId, u.gcmRegId ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"WHERE serviceProviderId = ? ";
	
			$stmt = $con->prepare($sql);
			if($stmt === false) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
			$stmt->bind_param('i', $serviceProviderId);
			$stmt->execute();
			$stmt->store_result();
			$serviceProviderData = fetchRow($stmt);
			$userId = $serviceProviderData['userId'];
			$regId = $serviceProviderData['gcmRegId'];
			
			$isPushNotificationTrigger = 'true';
			$info = "Send Push Notification from customer ( userId : " 
					. $customerUserId ." ) to service provider ( userId : " . $userId ." ) ";
		
	}else if(	$projectStatusId == ProjectStatus::$ConfirmRequest->getCode() ||
				$projectStatusId == ProjectStatus::$Quotation->getCode() ||
				$projectStatusId == ProjectStatus::$ConfirmQuotation->getCode() ||
				$projectStatusId == ProjectStatus::$ServiceStart->getCode() ||
				$projectStatusId == ProjectStatus::$ServiceProvRating->getCode() ||
				$projectStatusId == ProjectStatus::$PlanStartDate->getCode()){
		
				$sql = 	"SELECT cr.userId, u.gcmRegId ".
						"FROM customerRequest cr ".
						"INNER JOIN user u ON cr.userId = u.userId ".
						"WHERE cr.userId = ? ".
						"AND cr.customerRequestId = ? ";
				
				$stmt = $con->prepare($sql);
				if($stmt === false) {
					trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
				$stmt->bind_param('ii', $customerUserId, $customerRequestId );
				$stmt->execute();
				$stmt->store_result();
				$customerData = fetchRow($stmt);
				$userId = $customerData['userId'];
				$regId = $customerData['gcmRegId'];
		
				$isPushNotificationTrigger = 'true';
				$info =  "Send Push Notification from service provider( serviceProviderId : " 
						. $customerRequestData['serviceProviderId'] ." ) to customer ( userId : " . $userId ." ) ";
	}
	
// 	echo 'Customer Request ID : ' . $customerRequestId;
// 	echo "<br>";
// 	echo "<br>";
	
// 	echo 'Current Project Status Id : ' . $projectStatusId;
// 	echo "<br>";
// 	echo 'Current Project Status Name : ' . $customerRequestData['projectStatusName'];
// 	echo "<br>";
// 	echo "<br>";
	
	$newProjectStatusId = 0;
	$alreadyReadNotification = 0;
	$sendPushNotificationResult = "No Send";
	if( $isPushNotificationTrigger == 'true'){
		switch ($projectStatusId) {
			case ProjectStatus::$Pick->getCode():
				//Update the project status where project status is Pick
				$newProjectStatusId = ProjectStatus::$SelectedNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$SelectedNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$SelectedNotification->getDescription();
	
				break;
			case ProjectStatus::$ConfirmQuotation->getCode():
				//Update the project status where project status is Confirm Quotation
				$newProjectStatusId = ProjectStatus::$ConfirmQuotationNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$ConfirmQuotationNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$ConfirmQuotationNotification->getDescription();
	
				break;
			case ProjectStatus::$Deal->getCode():
				//Update the project status where project status is Deal
				$newProjectStatusId = ProjectStatus::$DealNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$DealNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$DealNotification->getDescription();
	
				break;
			case ProjectStatus::$ServiceDone->getCode():
				//Update the project status where project status is Service Done
				$newProjectStatusId = ProjectStatus::$ServiceDoneNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$ServiceDoneNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$ServiceDoneNotification->getDescription();
	
				break;
			case ProjectStatus::$CustomerRating->getCode():
				//Update the project status where project status is Customer Rating
				$newProjectStatusId = ProjectStatus::$CustomerRatingNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$CustomerRatingNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$CustomerRatingNotification->getDescription();
	
				$_POST["customerRequestId"] = $customerRequestId;
				include 'RatingCloseCustomerRequestCase.php';
				break;
			case ProjectStatus::$ConfirmRequest->getCode():
				//Update the project status where project status is Confirm Request
				$newProjectStatusId = ProjectStatus::$ConfirmRequestNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$ConfirmRequestNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$ConfirmRequestNotification->getDescription();
	
				break;
			case ProjectStatus::$Quotation->getCode():
				//Update the project status where project status is Quotation
				$newProjectStatusId = ProjectStatus::$QuotationNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$QuotationNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$QuotationNotification->getDescription();
	
				break;
			case ProjectStatus::$ServiceStart->getCode():
				//Update the project status where project status is Service Start
				$newProjectStatusId = ProjectStatus::$ServiceStartNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$ServiceStartNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$ServiceStartNotification->getDescription();
	
				break;
			case ProjectStatus::$ServiceProvRating->getCode():
				//Update the project status where project status is Service Provider Rating
				$newProjectStatusId = ProjectStatus::$ServiceProviderRatingNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$ServiceProviderRatingNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$ServiceProviderRatingNotification->getDescription();
	
				$_POST["customerRequestId"] = $customerRequestId;
				include 'RatingCloseCustomerRequestCase.php';
				
				break;
			case ProjectStatus::$PlanStartDate->getCode():
				//Update the project status where project status is Plan Start Date
				$newProjectStatusId = ProjectStatus::$PlanStartDateNotification->getCode();
				$customerRequestData['projectStatusId'] = ProjectStatus::$PlanStartDateNotification->getCode();
				$customerRequestData['projectStatusName'] = ProjectStatus::$PlanStartDateNotification->getDescription();
	
				break;
			default:
				echo "Still not define!!";
		}
	
		$sql = 	"UPDATE customerrequest ".
				"SET projectStatusId = ? ".
				", alreadyReadNotification = ? ".
				"WHERE customerRequestId = ?  ".
				"AND projectStatusId = ?  ";
		$stmt = $con->prepare($sql);
		if($stmt === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
		$stmt->bind_param('iiii', $newProjectStatusId, $alreadyReadNotification, $customerRequestId, $projectStatusId);
		$stmt->execute();
	
		if (isset($regId)) {
		
			$registatoinId = array($regId);
			$message = array(
					"notificationType" => "ProjectNotification",
					"jsonInfo" => $customerRequestData
			);
		
			$gcm = new GCM();
			$sendPushNotificationResult = $gcm->sendPushNotification($registatoinId, $message);
		}
	}

// 	echo 'New Project Status Id : ' . $newProjectStatusId;
// 	echo "<br>";
// 	echo 'New Project Status Name : ' . $customerRequestData['projectStatusName'];
// 	echo "<br>";
// 	echo "<br>";

// 	echo 'Is Push Notification Trigger : ' . $isPushNotificationTrigger;
// 	echo "<br>";
// 	echo 'Information : ' . $info;
// 	echo "<br>";
// 	echo 'User ID receiver : ' . $userId;
// 	echo "<br>";
// 	echo 'Reg ID receiver : ' . $regId;
// 	echo "<br>";
// 	echo 'Send Result : ' . $sendPushNotificationResult;
// 	echo "<br>";
// 	echo "<br>";
	
    echo json_encode($customerRequestData);
	
    include 'closedb.php';
?>