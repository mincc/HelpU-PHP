<?php
/*
 * 	22-10-2015 cm.choong : created
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$customerRequestId = $_POST["customerRequestId"];
    	$isLogicalDelete = $_POST["isLogicalDelete"];
	}else{
		$customerRequestId = 1;
		$isLogicalDelete = 1;
	}
	
	$sql = "";
	if ($isLogicalDelete == 1){
		$sql = 	"UPDATE customerrequest ".
			 	"SET isDelete = 1 ". 
				"WHERE customerRequestId = ? ";
	}else{
		$sql = 	"DELETE FROM customerrequest ".
				"WHERE customerRequestId = ? ";
	}
    
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $customerRequestId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>