<?php
/*
 * 	12-07-2015 cm.choong : created
 */
 
	if(!$debug){
		$customerRequestId = $_POST["customerRequestId"];
	}else{
		$customerRequestId = 44;
	}

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
	$stmt->bind_result($data);
	
	/* fetch values */
	while ($stmt->fetch()) {
		$data = (array('Total' => $data));
	}
	
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
	
?>