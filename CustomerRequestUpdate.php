<?php
/*
 * 	01-07-2015 cm.choong : created
 *  09-09-2015 cm.choong : add customerRatingValue, serviceProviderRatingValue, alreadyReadNotification;
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $serviceId = $_POST["serviceId"];
	    $description = $_POST["description"];
	    $userId = $_POST["userId"];
	    $projectStatusId = $_POST["projectStatusId"];
	    $customerRequestId = $_POST["customerRequestId"];
	    $serviceProviderId = $_POST["serviceProviderId"];
	    $quotation = $_POST["quotation"];
	    $customerRatingValue = $_POST["customerRatingValue"];
	    $serviceProviderRatingValue = $_POST["serviceProviderRatingValue"];
	    $alreadyReadNotification = $_POST["alreadyReadNotification"];
	}else{
	    $serviceId = 9;
	    $description = "i need cm.choong.";
	    $userId = 3;
	    $projectStatusId = 4;
	    $customerRequestId = 67;
	   	$serviceProviderId = 10;
	    $quotation = 10.00;
	    $customerRatingValue = 0.0;
	    $serviceProviderRatingValue = 0.0;
	    $alreadyReadNotification = 1;
	}
	
    $sql=	"UPDATE customerrequest ".
			"SET serviceId = ? ".
			", description = ? ".
			", userId = ? ".
			", projectStatusId = ? ".
			", serviceProviderId = ? ".
			", quotation = ? ".
			", customerRatingValue = ? ".
			", serviceProviderRatingValue = ? ".
			", alreadyReadNotification = ? ".
			"WHERE customerRequestId = ?";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "isiiidddii", $serviceId, $description, $userId, 
    		$projectStatusId, $serviceProviderId, $quotation, $customerRatingValue,
    		$serviceProviderRatingValue, $alreadyReadNotification, $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>