<?php
	include 'config.php';
	include 'opendb.php';
	
    $voterId = $_POST["voterId"];
    $targetUserId = $_POST["targetUserId"];
    $ratingValue = $_POST["ratingValue"];
    $ratingType = $_POST["ratingType"];
    $customerRequestId = $_POST["customerRequestId"];

// 	$voterId = 1;
// 	$targetUserId = 2;
// 	$ratingValue = 3;
// 	$ratingType = "c";
//  $customerRequestId = 1;
	
    $sql= 	"INSERT INTO rating ".
    		"(voterId, targetUserId, ratingValue, ratingType, customerRequestId) ".
    		"VALUES (?,?,?,?,?)";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "iidsi", $voterId, $targetUserId, $ratingValue, $ratingType, $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    //update the new total rating for each customer and service provider
    
    //Change the status of customer request
    if ($ratingType == "s") {
    	 $sql=	"UPDATE customerrequest ".
				"SET projectStatusId = 13 ". //Customer Rating (Customer give service provider rating)
				"WHERE customerRequestId = ?";
    }else if ($ratingType == "c") {
    	$sql=	"UPDATE customerrequest ".
				"SET projectStatusId = 14 ". //Service Provider Rating (Provider service give customer rating)
				"WHERE customerRequestId = ?";
    }
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'RatingCloseCustomerRequestCase.php';
    include 'closedb.php';
?>