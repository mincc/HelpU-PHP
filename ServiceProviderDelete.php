<?php
/*
 * 	01-09-2015 cm.choong : created
 *  21-09-2015 cm.choong : add logical delete 
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$serviceProviderId = $_POST["serviceProviderId"];
    	$isLogicalDelete = $_POST["isLogicalDelete"];
	}else{
		$serviceProviderId = 1;
		$isLogicalDelete = 1;
	}
	
	$sql = "";
	if ($isLogicalDelete == 1){
		$sql = 	"UPDATE serviceprovider ".
			 	"SET isDelete = 1 ". 
				"WHERE serviceProviderId = ? ";
	}else{
		$sql = 	"DELETE FROM serviceprovider ".
				"WHERE serviceProviderId = ? ";
	}
    
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $serviceProviderId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>