<?php
/*
 * 25-09-2015 cm.choong : created
 * 
 * */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $userId = $_POST["userId"];
	    $customerIssueTypeId = $_POST["customerIssueTypeId"];
	    $customerIssueStatusId = $_POST["customerIssueStatusId"];
	    $subject = $_POST["subject"];
	    $description =  $_POST["description"];
	}else{
	   	$userId = 1;
	    $customerIssueTypeId = 1;
	    $customerIssueStatusId = 1;
	    $subject = "Test Subject";
	    $description =  "Test Description";
	}

    $sql= 	"INSERT INTO customerissue".
    		"(userId, customerIssueTypeId, customerIssueStatusId, subject, description) ".
    		"VALUES (?,?,?,?,?) ";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "iiiss", $userId, $customerIssueTypeId, $customerIssueStatusId
    		, $subject, $description);
    mysqli_stmt_execute($statement);    
    mysqli_stmt_close($statement);

    $id = mysqli_insert_id($con);
    
    $_POST["customerIssueId"] = $id;
    include 'CustomerIssueGetByID.php';
?>