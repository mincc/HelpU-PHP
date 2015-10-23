<?php
/*
 * 	26-09-2015 cm.choong : created
 *  
 */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $chatMessageId = $_POST["chatMessageId"];
	    $id = $_POST["id"];
	    $message = $_POST["message"];
	    $userIdFrom = $_POST["userIdFrom"];
	    $userIdTo = $_POST["userIdTo"];
	}else{
	    $chatMessageId = 1;
	    $id = 1;
	    $message = "Test Message";
	    $userIdFrom = 1;
	    $userIdTo = 2;
	}
	
    $sql=	"UPDATE chatmessage ".
			"SET id = ? ".
 			",message = ? ". 
 			",userIdFrom = ? ". 
 			",userIdTo = ? ". 
			"WHERE chatMessageId = ? ";
     
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "isiii", $id, $message, $userIdFrom, 
    		$userIdTo, $chatMessageId);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>