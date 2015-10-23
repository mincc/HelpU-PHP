<?php
/*
 * 	01-07-2015 cm.choong : created
 *  16-10-2015 cm.choong : add gcmRegId
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
	    $gcmRegId = $_POST["gcmRegId"];
	}else{
		$userId = 7;
		$name = "Test Name";
		$username = "test";
	    $userContact= "60129999999";
	    $userEmail = "test@gmail.com";
	    $gcmRegId = "Test11111111111111";
	}
	
    $sql=	"UPDATE user ".
			"SET name = ?, ".
			"username = ?, ".
			"userContact = ?, ".
			"userEmail = ?, ".
			"gcmRegId = ? ".
			"WHERE userId = ?";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "sssssi", $name, $username, $userContact, $userEmail, $gcmRegId, $userId);
    mysqli_stmt_execute($statement);   
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>