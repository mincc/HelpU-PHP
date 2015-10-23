<?php
/*
 * 01-07-2015 cm.choong : created
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';

	if(!$debug)
	{
		$transactionId = $_POST["transactionId"];
		$refNo = $_POST["refNo"];
		$amount = $_POST["amount"];
		$remark = $_POST["remark"];
		$authCode = $_POST["authCode"];
		$errDesc = $_POST["errDesc"];
	}else{
		$transactionId = "Test Transaction ID";
		$refNo = "Ref No Test";
		$amount = "Amount Test";
		$remark = "Remark Test";
		$authCode = "Auth Code Test";
		$errDesc = "Err Code Test";
	}

    
    $sql = 	"INSERT INTO transaction(transactionId, refNo, amount, remark, authCode, errDesc) ".
      		"VALUES (?, ?, ?, ?, ?, ?)";
    
    $statement = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($statement, "ssssss", $transactionId, $refNo, $amount, $remark, $authCode, $errDesc);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    $id = mysqli_insert_id($con);  

    $sql = 	"SELECT id, transactionId, refNo, amount, remark, authCode, errDesc ".
			"FROM transaction ".
			"WHERE id = ?";
    
    //Prepare statement
    $stmt = $con->prepare($sql);
    if($stmt === false) {
    	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
    
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('i', $id);
    
	//Execute statement
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
    
	echo json_encode($data);
    	
    include 'closedb.php';
?>