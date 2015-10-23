<?php
/*
 * 	01-07-2015 cm.choong : created
 *  15-10-2015 cm.choong : add gcmRegId
 *  22-10-2015 cm.choong : update the userJoinDate
 */
	include 'config.php';
	include 'opendb.php';

	if(!$debug){
	    $name = $_POST["name"];
	    $username = $_POST["username"];
	    $password = $_POST["password"];
	    $userContact = $_POST["userContact"];
	    $userEmail = $_POST["userEmail"];
	    $gcmRegId = $_POST["gcmRegId"];
	}else{
		$name = "TestUser 01";
		$username = "cm.choong";
		$password = "Password1233";
		$userContact = "60124445558";
		$userEmail = "gdj@gdc.co.com";
		$gcmRegId = "TEST1bHNhB5iF0Df7ODU5ZnBteUOSyjsAuj28FSdVkoapoZoiiEKN2pHUpM7E26Sy2qZpNF4FFmwhRL66d-D7oyvaCTMeCXY9RMU7ePa0efApIpRwmocShhrrZMiU7gQX33pPL5sSdmy";
	}
    
    $sql = 	"INSERT INTO user (name, username, password, userContact, userEmail, gcmRegId, userJoinDate) ".
    		"VALUES (?, ?, ?, ?, ?, ?, now())";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "ssssss", $name, $username, $password, $userContact, $userEmail, $gcmRegId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>