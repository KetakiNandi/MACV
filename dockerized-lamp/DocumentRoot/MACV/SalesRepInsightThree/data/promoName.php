<?php 
require_once(__DIR__.'/config.php');
session_start();
$param = $_GET['param'];
if($param=="YES"){
  unset($_SESSION["stDate"]);
  unset($_SESSION["endDate"]);
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  session_destroy();
  }

if(!empty($_GET['startDate'])){
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
 $_SESSION['stDate'] =  $_GET['startDate'];
  
}
else
{
  if(!isset($_SESSION['stDate']))
  	$_SESSION['stDate'] =  "01-Jan-17";
}

if(!empty($_GET['endDate'])){
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['endDate']= $_GET['endDate'];
}
else
{
  if(!isset($_SESSION['endDate']))
    $_SESSION['endDate'] =  "31-Dec-17";
}
/*
echo $_SESSION['endDate'];
echo $_SESSION['stDate'];
die;
*/

if(!empty($_GET['zoneparam'])){
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['zones'] =  $_GET['zoneparam'];
  }

if(!empty($_GET['Stateparam'])){
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['states'] =  $_GET['Stateparam'];
  }

if(!empty($_GET['Cityparam'])){
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['cities'] =  $_GET['Cityparam'];
  }

if(!empty($_GET['POSTypeparam'])){
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['POSTypes'] =  $_GET['POSTypeparam'];
}

if(!empty($_GET['Siteparam'])){
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['Sites'] =  $_GET['Siteparam'];
}

if(!empty($_GET['categoryparam'])){
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['Categories'] =  $_GET['categoryparam'];
}

if(!empty($_GET['ProNameparam'])){
  unset($_SESSION['EMP']);
  $_SESSION['ProNames'] =  $_GET['ProNameparam'];
}

if(!empty($_GET['EmpIdparam'])){
  $_SESSION['EMP'] =  $_GET['EmpIdparam'];
}

$zonename = $_SESSION['zones'];
$str_explode=explode(",",$zonename);
$statename = $_SESSION['states'];
$str_explodeState=explode(",",$statename);
$Cityname = $_SESSION['cities'];
$str_explodeCity=explode(",",$Cityname);
$POSTypeparam = $_SESSION['POSTypes'];
$str_explodePOSType=explode(",",$POSTypeparam);
$Sitename = $_SESSION['Sites'];
$str_explodeSite=explode(",",$Sitename);
$categoryname = $_SESSION['Categories'];
$str_explodeCatgory=explode(",",$categoryname);
$EmpIdname = $_SESSION['EMP'];
$str_explodeEmpId=explode(",",$EmpIdname);
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17

/////LATER/////
$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];

$connection = new MongoDB\Driver\Manager("mongodb://mongo:27017");

$miliStartDate = strtotime($startDate);
$miliEndDate = strtotime($endDate);
$miliStartDateSession = $miliStartDate;
$miliEndDateSession = $miliEndDate;

$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

//$catefilter['Category'] = $categoryname;
//$Empfilter['SalespersonId'] = $EmpIdname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

 /////////EMP///////////
 //$Empfilter['SalesRepNameid'] = $EmpIdname;
 $dateempcatfilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateempcatpostypefilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CAT//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 
if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datesourcesitecatpromopostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
    $data = executeBlock($datessitecatSRpostypefilterSession , 'datesourcesitecatpromopostypeemp');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datesourcesitecatpromopostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datessitecatpostypefilterSession , 'datesourcesitecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DatesourcesitecatpromoEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
    $data = executeBlock($datessitecatSRfilterSession , 'DatesourcesitecatpromoEmpid');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datessitecatfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateSourceSitePromoNameWiseCategorywisePerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datessitecatfilterSession , 'DateSourceSitePromoNameWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datecitycatSRpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
    $data = executeBlock($datecitycatSRpostypefilterSession , 'datecitycatpromopostypeemp');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitycatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datecitycatpostypefilterSession , 'datecitycatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datecitycatSRfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DatecitycatpromoEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datecitycatSRfilterSession , 'DatecitycatpromoEmpid');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datecitycatfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateCityPromoNameWiseCategorywisePerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datecitycatfilterSession , 'DateCityPromoNameWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datestatecatpromopostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datestatecatSRpostypefilterSession , 'datestatecatpromopostypeemp');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datestatecatpromopostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datestatecatpostypefilterSession , 'datestatecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DatestatecatpromoEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datestatecatSRfilterSession , 'DatestatecatpromoEmpid');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datestatecatfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStatePromoNameWiseCategorywisePerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datestatecatfilterSession , 'DateStatePromoNameWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datezonecatSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($datezonecatSRpostypefilterSession , 'datezonecatpromopostypeemp');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezonecatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($datezonecatpostypefilterSession , 'datezonecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datezonecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DatezonecatpromoEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($datezonecatSRfilterSession , 'DatezonecatpromoEmpid');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datezonecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZonePromoNameWiseCategorywisePerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($datezonecatfilterSession , 'DateZonePromoNameWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($dateempcatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecatemppromopostype", $query);//collection RepName and category and promo name
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($dateempcatpostypefilterSession , 'datecatemppromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecatpromopostype", $query);//collection RepName and category and promo name
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($datecatpostypefilterSession , 'datecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($dateempcatfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateEmpIdPromoNameWiseCategorywisePerformanceQtn", $query);//collection RepName and category and promo name
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($dateempcatfilterSession , 'DateEmpIdPromoNameWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
 // $query = new MongoDB\Driver\Query($datecatfilterSession); 

          // $rows  = $connection->executeQuery("SaleRepInsight.DateWisePromoWiseCategorywisePerformanceQtn", $query);//collection RepName and category and promo name
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
     $data = executeBlock($datecatfilterSession , 'DateWisePromoWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($startDate && $endDate)
{
  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datefilter , 'PromoNameWiseSalesPerformanceQtn');
   echo json_encode($data);
}
else if($POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($POSTypefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseZSCSWisePromoName", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
          //echo json_encode($data);
  $data = executeBlock($POSTypefilter , 'PosTypeWiseZSCSWisePromoName');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($SubCatparamfilter['SubCategory'])
{
  // $query = new MongoDB\Driver\Query($SubCatparamfilter); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSubCatWisePerformanceQtn", $query);//collection RepName and category and promo name
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($SubCatparamfilter , 'PromoNameWiseSubCatWisePerformanceQtn');
  echo json_encode($data);
}
else if($itemcodeparamfilter['Item_Code'])
{
  // $query = new MongoDB\Driver\Query($itemcodeparamfilter); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWisePromoName", $query);//collection RepName and category and promo name
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromeNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromeNo),"PromoName"=>trim($row->PromeName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($itemcodeparamfilter , 'TopTenSellingWisePromoName');
  echo json_encode($data);
}
else
{
  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datefilter , 'PromoNameWiseSalesPerformanceQtn');
  echo json_encode($data);
}

function executeBlock($queryVar,$collection){
   $rows   = getdata($queryVar,$collection);
   $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
	$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);
	return($dataWithDateParam);

}

?>
