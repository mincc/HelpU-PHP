<?php
	include 'config.php';
	include 'opendb.php';
	
    $serviceId = $_POST["serviceId"];
    $description = $_POST["description"];
    $userId = $_POST["userId"];
    $projectStatusId = $_POST["projectStatusId"];
    $customerRequestId = $_POST["customerRequestId"];
    $serviceProviderId = $_POST["serviceProviderId"];
    $quotation = $_POST["quotation"];
    
//     $serviceId = 4;
//     $description = "Urgent";
//     $userId = 3;
//     $projectStatusId = 2;
//     $customerRequestId = 1;
//    	$serviceProviderId = 6;
//     $quotation = 100.90;
	
    $sql=	"UPDATE customerrequest ".
			"SET serviceId = ?, ".
			"description = ?, ".
			"userId = ?, ".
			"projectStatusId = ?, ".
			"serviceProviderId = ?, ".
			"quotation = ? ".
			"WHERE customerRequestId = ?";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "isiiidi", $serviceId, $description, $userId, $projectStatusId, $serviceProviderId, $quotation, $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>