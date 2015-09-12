<?php
/*
 * 	15-07-2015 cm.choong : created
 *  18-08-2015 cm.choong : update the service provider ratingValue column
 *  09-09-2015 cm.choong : update the customerRatingValue, serviceProviderRatingValue
 */
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $voterId = $_POST["voterId"];
	    $targetUserId = $_POST["targetUserId"];
	    $ratingValue = $_POST["ratingValue"];
	    $ratingType = $_POST["ratingType"];
	    $customerRequestId = $_POST["customerRequestId"];
	}else{
		$voterId = 1;
		$targetUserId = 3;
		$ratingValue = 3.5;
		$ratingType = "s";
	 	$customerRequestId = 44;
	}
	
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
				"SET projectStatusId = 13". //Customer Rating (Customer give service provider rating)
				", serviceProviderRatingValue = ? ".
				"WHERE customerRequestId = ?";

    }else if ($ratingType == "c") {
    	$sql=	"UPDATE customerrequest ".
				"SET projectStatusId = 14 ". //Service Provider Rating (Provider service give customer rating)
				", customerRatingValue = ? ".
				"WHERE customerRequestId = ?";
    }
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "di", $ratingValue, $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    if ($ratingType == "s") {
    	include 'RatingGetServiceProviderRatingByServiceId.php';
    }else{
    	
    }
    
    include 'closedb.php';
?>