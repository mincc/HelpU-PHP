<?php
/*
 * 23-10-2015 cm.choong : created
 *
 */
 
class StringUtils{
	//put your code here
	// constructor
	function __construct() {
		 
	}
	
	function getStringBetween($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
}
?>