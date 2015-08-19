<?php
	include 'config.php';
	include 'opendb.php';
	
    $serviceProviderId = $_POST["serviceProviderId"];
	
    $sql = 	"DELETE FROM serviceprovider ".
    		"WHERE serviceProviderId = ?"; 
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "i", $serviceProviderId);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>