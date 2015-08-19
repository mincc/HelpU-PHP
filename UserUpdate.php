<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug)
	{
		$userId = $_POST["userId"];
	    $name = $_POST["name"];
	    $username = $_POST["username"];
	    $userContact= $_POST["userContact"];
	    $userEmail = $_POST["userEmail"];
	}else{
		$userId = 7;
		$name = "Test Name";
		$username = "test";
	    $userContact= "60129999999";
	    $userEmail = "test@gmail.com";
	}
	
    $sql=	"UPDATE user ".
			"SET name = ?, ".
			"username = ?, ".
			"userContact = ?, ".
			"userEmail = ? ".
			"WHERE userId = ?";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "ssssi", $name, $username, $userContact, $userEmail, $userId);
    mysqli_stmt_execute($statement);   
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>