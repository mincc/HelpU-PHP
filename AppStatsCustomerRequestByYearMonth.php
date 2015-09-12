<?php
/*
 * 	01-09-2015 cm.choong : created
 */

	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';

	$sql = 	"SELECT ".
 			"	YEAR(createdDate) AS year, ".
	 		" 	DATE_FORMAT(createdDate, '%b') AS month, ".
 			"	SUM(quotation) AS totalQuotation, ".
 			"	COUNT(*) AS totalProject ".
			"FROM customerrequest ".
			"WHERE createdDate BETWEEN '2014-01-01' AND '2100-12-01' ".
			"GROUP BY YEAR(createdDate), MONTH(createdDate) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
  	$data = fetchArray($stmt);  	
	echo json_encode($data);

	include 'closedb.php';

?>
