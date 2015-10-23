<?php
/*
 * 19-10-2015 cm.choong : created
 * 
 * */
 
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
	    $id = $_POST["id"];
	    $message = $_POST["message"];
	    $userIdFrom = $_POST["userIdFrom"];
	    $userIdTo = $_POST["userIdTo"];
	}else{
	   	$id = 1;
	    $message = "Test Message : Hello World, how are u today";
	    $userIdFrom = 2;
	    $userIdTo = 1;
	}

    $sql= 	"INSERT INTO chatmessage ".
    		"(id, message, userIdFrom, userIdTo) ".
    		"VALUES (?, ?, ?, ?) ";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "isii", $id, $message, $userIdFrom, $userIdTo);
    mysqli_stmt_execute($statement);    
    mysqli_stmt_close($statement);

    $id = mysqli_insert_id($con);
    
    $_POST["chatMessageId"] = $id;
    include 'ChatMessageGetByID.php';
    
    $_POST["chatMessageId"] = $id;
    include 'GCMSendMessage.php';
?>