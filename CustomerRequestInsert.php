<?php
	include 'config.php';
	include 'opendb.php';
	
    $serviceId = $_POST["serviceId"];
    $description = $_POST["description"];
    $userId = $_POST["userId"];
    $projectStatusId = $_POST["projectStatusId"];

//     $serviceId = 1;
//     $description = "Testing";
//     $userId = 1;
//     $projectStatusId =1;
	
    $sql= 	"INSERT INTO customerrequest".
    		"(serviceId, description, userId, projectStatusId) ".
    		"VALUES (?,?,?,?)";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "isii", $serviceId, $description, $userId, $projectStatusId);
    mysqli_stmt_execute($statement);    
    mysqli_stmt_close($statement);

    $id = mysqli_insert_id($con);
    
    $_POST["customerRequestId"] = $id;
    include 'CustomerRequestGetByID.php';
?>