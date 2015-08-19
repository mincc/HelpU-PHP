<?php
	include 'config.php';
	include 'opendb.php';
	
    $user_id = $_POST["userId"];
    $service_id = $_POST["serviceId"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
	
    $statement = mysqli_prepare($con, "INSERT INTO serviceprovider (userId, serviceId, phone, email) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement, "iiss", $user_id, $service_id, $phone, $email);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>