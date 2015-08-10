<?php
// 	include 'config.php';
// 	include 'opendb.php';

// 	$customerRequestId = 5;
	$customerRequestId = $_POST["customerRequestId"];

	//Close the customer request if both side already rating
	$sql = 	"SELECT COUNT(*) AS Total FROM rating ".
			"WHERE customerRequestId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('i', $customerRequestId);

	//Execute statement
	$stmt->execute();

	/* Fetch result to array */
	$res = $stmt->get_result();
	$data = $res->fetch_array(MYSQLI_ASSOC);

	if($data[Total] >= 2)
	{
		$sql=	"UPDATE customerrequest ".
				"SET projectStatusId = 15 ". //Project Done
				"WHERE customerRequestId = ?";

		$statement = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($statement, "i", $customerRequestId);
		mysqli_stmt_execute($statement);
		
		mysqli_stmt_close($statement);
	}
	
//  	include 'closedb.php';
?>