<?php
/*
 * 	01-07-2015 cm.choong : created
 *  04-09-2015 cm.choong : add more notification
 *  09-09-2015 cm.choong : add customerRatingValue, serviceProviderRatingValue, alreadyReadNotification;
 *  12-09-2015 cm.choong : add userEmail and userContact
 *  20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
// 	include 'config.php';
// 	include 'opendb.php';
// 	require_once 'DBUtils.php';
// 	include 'ProjectStatus.php';
	
// 	if(!$debug){
//     	$userId = $_POST["userId"];
// 	}else{
// 		$userId = 1;
// 	}
	
//     $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
// 			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
//     		"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
// 			"FROM customerrequest cr ".
// 			"INNER JOIN user u ON cr.userId = u.userId ".
// 			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
// 			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
// 			"INNER JOIN serviceprovider sp ON cr.serviceProviderId = sp.serviceProviderId ".
// 			"WHERE ( cr.projectStatusId = 3 ". 	//Pick (3) 
// 			"OR cr.projectStatusId = 8 ". 		//Deal (8)
// 			"OR cr.projectStatusId = 12 ". 		//Service Done (12)
// 			"OR cr.projectStatusId = 13 ) ". 	//Customer Rating (13)
// 			"AND cr.serviceProviderId is not null ".
// 			"AND sp.userId = ?  ".
//     		"UNION ".
//     		"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
// 			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
//   			"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
// 			"FROM customerrequest cr ".
// 			"INNER JOIN user u ON cr.userId = u.userId ".
// 			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
// 			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
//   			"WHERE cr.userId = ?  ".
//   			"AND ( cr.projectStatusId = 5 ".	//Confirm Request (5)	
//   			"OR cr.projectStatusId = 6 ". 		//Quotation (6)
//   			"OR cr.projectStatusId = 7 ". 		//Confirm Quotation (7)
//   			"OR cr.projectStatusId = 11 ". 		//Service Start (11)
//   			"OR cr.projectStatusId = 14 ". 		//Service Provider Rating (14)
//   			"OR cr.projectStatusId = 26 ) "	;	//Plan Start Date (26)
    
// 	//Prepare statement
// 	$stmt = $con->prepare($sql);
// 	if($stmt === false) {
// 	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
// 	$stmt->bind_param('ii', $userId, $userId);
// 	$stmt->execute();
// 	$data = fetchArray($stmt);
	
// 	$i = 0;
// 	foreach($data as $row)
// 	{
// 		$projectStatusId = $row['projectStatusId'];
// 		$customerRequestId = $row['customerRequestId'];
		
// 		switch ($projectStatusId) {
// 			case ProjectStatus::$Pick->getCode():
// 				//Update the project status where project status is Pick
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 4 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 3  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$SelectedNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$SelectedNotification->getDescription();

// 				break;
// 			case ProjectStatus::$ConfirmQuotation->getCode():
	
// 				//Update the project status where project status is Confirm Quotation
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 21 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 7  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$ConfirmQuotationNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$ConfirmQuotationNotification->getDescription();
				
// 				break;
// 			case ProjectStatus::$Deal->getCode():
// 				//Update the project status where project status is Deal
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 9 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 8  ";
			
// 				$data[$i]['projectStatusId'] = ProjectStatus::$DealNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$DealNotification->getDescription();
			
// 				break;
// 			case ProjectStatus::$ServiceDone->getCode():
// 				//Update the project status where project status is Service Done
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 23 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 12  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$ServiceDoneNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$ServiceDoneNotification->getDescription();
				
// 				break;
// 			case ProjectStatus::$CustomerRating->getCode():
// 				//Update the project status where project status is Customer Rating
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 24 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 13  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$CustomerRatingNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$CustomerRatingNotification->getDescription();
				
// 				$_POST["customerRequestId"] = $customerRequestId;
// 				include 'RatingCloseCustomerRequestCase.php';
// 				break;
// 			case ProjectStatus::$ConfirmRequest->getCode():
// 				//Update the project status where project status is Confirm Request
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 19 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 5  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$ConfirmRequestNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$ConfirmRequestNotification->getDescription();
				
// 				break;
// 			case ProjectStatus::$Quotation->getCode():
// 				//Update the project status where project status is Quotation
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 20 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 6  ";

// 				$data[$i]['projectStatusId'] = ProjectStatus::$QuotationNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$QuotationNotification->getDescription();
				
// 				break;
// 			case ProjectStatus::$ServiceStart->getCode():
// 				//Update the project status where project status is Service Start
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 22 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 11  ";		

// 				$data[$i]['projectStatusId'] = ProjectStatus::$ServiceStartNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$ServiceStartNotification->getDescription();
				
// 				break;
// 			case ProjectStatus::$ServiceProvRating->getCode():
// 				//Update the project status where project status is Service Provider Rating
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 25 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 14  ";	

// 				$data[$i]['projectStatusId'] = ProjectStatus::$ServiceProviderRatingNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$ServiceProviderRatingNotification->getDescription();
				
// 				$_POST["customerRequestId"] = $customerRequestId;
// 				include 'RatingCloseCustomerRequestCase.php';
// 				break;
// 			case ProjectStatus::$PlanStartDate->getCode():
// 				//Update the project status where project status is Plan Start Date
// 				$sql = 	"UPDATE customerrequest ".
// 						"SET projectStatusId = 27 ".
// 						", alreadyReadNotification = 0 ".
// 						"WHERE customerRequestId = ?  ".
// 						"AND projectStatusId = 26  ";
					
// 				$data[$i]['projectStatusId'] = ProjectStatus::$PlanStartDateNotification->getCode();
// 				$data[$i]['projectStatusName'] = ProjectStatus::$PlanStartDateNotification->getDescription();
					
// 				break;
// 			default:
// 				echo "Still not define!!";
// 		}
		
// 		$stmt = $con->prepare($sql);
// 		if($stmt === false) {
// 			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

// 		$stmt->bind_param('i', $customerRequestId);
// 		$stmt->execute();
		
// 		$i++;
// 	}
	
//     echo json_encode($data);
	
//     include 'closedb.php';
?>