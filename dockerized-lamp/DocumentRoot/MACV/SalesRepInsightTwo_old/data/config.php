<?php
	$conn					= 	new MongoDB\Driver\Manager("mongodb://127.0.0.1/");
	$db						=	"SaleRepInsight.";
	
	function getData($queryString , $collection){
		
		$coll 				= 	$GLOBALS['db'].$collection;
  		$query 				= 	new MongoDB\Driver\Query($queryString); 
  		$rows  				= 	$GLOBALS['conn']->executeQuery($coll, $query);
  		return $rows;	
	}
	
?>