<?php
/*
 * 	26-09-2015 cm.choong : created
 *  
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $userId = $_POST["userId"];
	    $subject = $_POST["subject"];
	    $description = $_POST["description"];
	    $customerIssueTypeId = $_POST["customerIssueTypeId"];
	    $customerIssueStatusId = $_POST["customerIssueStatusId"];
	    $customerIssueId = $_POST["customerIssueId"];
	}else{
	    $userId = 1;
	    $subject = "Test Subject";
	    $description = "Test Description";
	    $customerIssueTypeId = 1;
	    $customerIssueStatusId = 2;
	    $customerIssueId = 1;
	}
	
    $sql=	"UPDATE customerissue ".
			"SET userId = ? ".
 			",subject = ? ". 
 			",description = ? ". 
 			",customerIssueTypeId = ? ". 
 			",customerIssueStatusId = ? ".
			"WHERE customerIssueId = ? ";
     
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "issiii", $userId, $subject, $description, 
    		$customerIssueTypeId, $customerIssueStatusId, $customerIssueId);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>