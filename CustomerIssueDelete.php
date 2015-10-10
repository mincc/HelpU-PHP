<?php
/*
 * 	26-09-2015 cm.choong : created
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$customerIssueId = $_POST["customerIssueId"];
    	$isLogicalDelete = $_POST["isLogicalDelete"];
	}else{
		$customerIssueId = 38;
		$isLogicalDelete = 1;
	}
	
	$sql = "";
	if ($isLogicalDelete == 1){
		$sql = 	"UPDATE customerissue ".
			 	"SET isDelete = 1 ". 
				"WHERE customerIssueId = ? ";
	}else{
		$sql = 	"DELETE FROM customerissue ".
				"WHERE customerIssueId = ? ";
	}
    
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $customerIssueId);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>