<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';

    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $userContact = $_POST["userContact"];
    $userEmail = $_POST["userEmail"];
    
    $sql = 	"INSERT INTO user (name, username, password, userContact, userEmail) ".
    		"VALUES (?, ?, ?, ?, ?)";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "sssss", $name, $username, $password, $userContact, $userEmail);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>