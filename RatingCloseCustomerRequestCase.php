<?php
/*
 * 	12-07-2015 cm.choong : created
 */
 
	if(!$debug){
		$customerRequestId = $_POST["customerRequestId"];
	}else{
// 		include 'config.php';
// 		include 'opendb.php';
		$customerRequestId = 29;
	}

	//Close the customer request if both side already rating
	$sql02 =	"SELECT COUNT(*) AS Total ".
				"FROM rating ".
				"WHERE customerRequestId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql02);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->bind_param('i', $customerRequestId);
	$stmt->execute();
	$stmt->bind_result($data02);
	
	/* fetch values */
	while ($stmt->fetch()) {
		$data02 = (array('Total' => $data02));
	}

	if($data02['Total'] >= 2)
	{
		$sql02=	"UPDATE customerrequest ".
				"SET projectStatusId = 15 ". //Project Done
				"WHERE customerRequestId = ?";

		$statement = mysqli_prepare($con, $sql02);
		mysqli_stmt_bind_param($statement, "i", $customerRequestId);
		mysqli_stmt_execute($statement);
		
		mysqli_stmt_close($statement);
	}
	
?>