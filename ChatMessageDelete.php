<?php
/*
 * 	19-10-2015 cm.choong : created
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$chatMessageId = $_POST["chatMessageId"];
    	$isLogicalDelete = $_POST["isLogicalDelete"];
	}else{
		$chatMessageId = 38;
		$isLogicalDelete = 1;
	}
	
	$sql = "";
	if ($isLogicalDelete == 1){
		$sql = 	"UPDATE chatmessage ".
			 	"SET isDelete = 1 ". 
				"WHERE chatMessageId = ? ";
	}else{
		$sql = 	"DELETE FROM chatmessage ".
				"WHERE chatMessageId = ? ";
	}
    
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $chatMessageId);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>