<?php
	$conn					= 	new MongoDB\Driver\Manager("mongodb://mongo:27017");
	$db						=	"SaleRepInsight.";
	
	function getData($queryString , $collection){
		
		$coll 				= 	$GLOBALS['db'].$collection;
  		$query 				= 	new MongoDB\Driver\Query($queryString); 
  		$rows  				= 	$GLOBALS['conn']->executeQuery($coll, $query);
  		return $rows;	
	}
?>
