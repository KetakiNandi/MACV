<?php

$startDate = $_GET['startDate'];//01-Jan-17
$endDate = $_GET['endDate'];//31-Jan-17
$miliStartDate = strtotime($startDate);
$miliEndDate = strtotime($endDate);

$mng                  = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));


if($startDate && $endDate)
{
 $query                = new MongoDB\Driver\Query($datefilter); 

$rows                 = $mng->executeQuery("SaleRepInsight.consecutive3DaySaleZero", $query);
$data                 = array();
$findCounter          = 0;

foreach ($rows as $row){
 // $milliseconds = $row->date->toDateTime();
  for($i=0;$i<count($data);$i++){
    if($data[$i]["SalesRepNameid"]==$row->SalesRepNameid){        
     
      
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("Date"=>($milliseconds->format('d-M-y')),"Source Site"=>($row->SourceSite),"SalesRep"=>($row->SalesRepName));
  } else {
    $findCounter  = 0;
  }
}
array_walk_recursive($data, function (&$b) { $b = (string)$b; });
echo json_encode($data);


}

else
{
 $query                = new MongoDB\Driver\Query([]); 

$rows                 = $mng->executeQuery("SaleRepInsight.consecutive3DaySaleZero", $query);
$data                 = array();
$findCounter          = 0;

foreach ($rows as $row){
 $milliseconds = $row->date->toDateTime();
  for($i=0;$i<count($data);$i++){
    if($data[$i]["SalesRepNameid"]==$row->SalesRepNameid){        
     
      
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("Date"=>($milliseconds->format('d-M-y')),"Source Site"=>($row->SourceSite),"Employee Name"=>($row->SalesRepName));
  } else {
    $findCounter  = 0;
  }
}
array_walk_recursive($data, function (&$b) { $b = (string)$b; });
echo json_encode($data);
}
//

?>