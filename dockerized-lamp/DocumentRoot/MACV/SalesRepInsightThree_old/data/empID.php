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
$Promoname = $_SESSION['ProNames'];
$str_explodePromo=explode(",",$Promoname);
$EmpIdname = $_SESSION['EMP'];
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17

//////LATER/////////
$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

$miliStartDate = strtotime($startDate);
$miliEndDate = strtotime($endDate);
$miliStartDateSession = $miliStartDate;
$miliEndDateSession = $miliEndDate;

$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

/////////PROMO///////////
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatpromopostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 //////CAT//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
//echo "<pre>"; print_r($datezonecatpromofilterSession);die;

////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
      {
      // $query = new MongoDB\Driver\Query($datessitecatpostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datesourcesitecatpostypeemp", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datessitecatpostypefilterSession , 'datesourcesitecatpostypeemp');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
      // $query = new MongoDB\Driver\Query($datessitepostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datesourcesiteempidpostype", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datessitepostypefilterSession , 'datesourcesiteempidpostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
      {
      // $query = new MongoDB\Driver\Query($datessitecatpromofilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatesourcesitecatpromoEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datessitecatpromofilterSession , 'DatesourcesitecatpromoEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
      {
      // $query = new MongoDB\Driver\Query($datessitecatfilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatesourcesitecatEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datessitecatfilterSession , 'DatesourcesitecatEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
      // $query = new MongoDB\Driver\Query($datessitefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatesourcesiteEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datessitefilterSession , 'DatesourcesiteEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
      // $query = new MongoDB\Driver\Query($datecitycatpostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpostypeemp", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datecitycatpostypefilterSession , 'datecitycatpostypeemp');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
      // $query = new MongoDB\Driver\Query($datecitypostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datecityempidpostype", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
	    $data = executeBlock($datecitypostypefilterSession , 'datecityempidpostype');
     $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
      // $query = new MongoDB\Driver\Query($datecitycatpromofilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatecitycatpromoEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datecitycatpromofilterSession , 'DatecitycatpromoEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
      // $query = new MongoDB\Driver\Query($datecitycatfilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatecitycatEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datecitycatfilterSession , 'DatecitycatEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
      // $query = new MongoDB\Driver\Query($datecityfilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatecityEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datecityfilterSession , 'DatecityEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
      // $query = new MongoDB\Driver\Query($datestatecatpostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datestatecatpostypeemp", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datestatecatpostypefilterSession , 'datestatecatpostypeemp');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
      // $query = new MongoDB\Driver\Query($datestatepostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datestateempidpostype", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
   $data = executeBlock($datestatepostypefilterSession , 'datestateempidpostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
      // $query = new MongoDB\Driver\Query($datestatecatpromofilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatestatecatpromoEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datestatecatpromofilterSession , 'DatestatecatpromoEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
      // $query = new MongoDB\Driver\Query($datestatecatfilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatestatecatEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
	   $data = executeBlock($datestatecatfilterSession , 'DatestatecatEmpid');
     $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
      // $query = new MongoDB\Driver\Query($datestatefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DatestateEmpid", $query);
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
  $data = executeBlock($datestatefilterSession , 'DatestateEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
   //echo "<pre>"; print_r($_SESSION['stDate']);die;
  // $query = new MongoDB\Driver\Query($datezonecatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datezonecatpostypefilterSession , 'datezonecatpostypeemp');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
   //echo "<pre>"; print_r($_SESSION['stDate']);die;
  // $query = new MongoDB\Driver\Query($datezonepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezoneempidpostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
      $data = executeBlock($datezonepostypefilterSession , 'datezoneempidpostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
   //echo "<pre>"; print_r($_SESSION['stDate']);die;
  // $query = new MongoDB\Driver\Query($datezonecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DatezonecatpromoEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datezonecatpromofilterSession , 'DatezonecatpromoEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{

  // $query = new MongoDB\Driver\Query($datezonecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DatezonecatEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
  $data = executeBlock($datezonecatfilterSession , 'DatezonecatEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{

  // $query = new MongoDB\Driver\Query($datezonefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DatezoneEmpid", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
         // echo json_encode($data);
      $data = executeBlock($datezonefilterSession , 'DatezoneEmpid');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

}
else if($Promoname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
      // $query = new MongoDB\Driver\Query($datecatpromopostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datecatemppromopostype", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datecatpromopostypefilterSession , 'datecatemppromopostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Promoname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
      // $query = new MongoDB\Driver\Query($datecatpromofilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DateEmpIdPromoNameWiseCategorywisePerformanceQtn", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datecatpromofilterSession , 'DateEmpIdPromoNameWiseCategorywisePerformanceQtn');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
      // $query = new MongoDB\Driver\Query($datecatpostypefilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.datecatemppostype", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datecatpostypefilterSession , 'datecatemppostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
      // $query = new MongoDB\Driver\Query($datecatfilterSession); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWiseCategorywisePerformanceQtn", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
          //echo json_encode($data);
        $data = executeBlock($datecatfilterSession , 'DateWiseEmpIdWiseCategorywisePerformanceQtn');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datepostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecatemppostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datepostypefilterSession , 'datecatemppostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($startDate && $endDate)
{

  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datefilter , 'SalesRepWiseSalesPerformanceQtn');
        echo json_encode($data);
}

else if($SubCatparamfilter['SubCategory'])
      {
      // $query = new MongoDB\Driver\Query($SubCatparamfilter); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSubCatWisePerformanceQtn", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
      //     echo json_encode($data);
        $data = executeBlock($SubCatparamfilter , 'SalesRepWiseSubCatWisePerformanceQtn');
        echo json_encode($data);
      }

      else if($Empfilter['SalesRepNameid'])
      {
      // $query = new MongoDB\Driver\Query($Empfilter); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
      //     echo json_encode($data);
        $data = executeBlock($Empfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName');
        echo json_encode($data);
      }
 else if($itemcodeparamfilter['Item_Code'])
      {
      // $query = new MongoDB\Driver\Query($itemcodeparamfilter); 
      //     $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWiseSalesRep", $query);//connection SaleRep Category and promoname
      //     $result = array();
      //     foreach($rows as $row){
      //         for($i=0;$i<count($data);$i++){
      //         if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
      //           $findCounter    = 1;
      //           $oldV           = $data[$i]["count"];
      //           $data[$i]["count"]    = $oldV+1;          
      //           break;
      //         }
      //       }
      //       if($findCounter==0){
      //         $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
      //       } 
      //       else {
      //         $findCounter  = 0;
      //       }
      //     }
      //     echo json_encode($data);
        $data = executeBlock($itemcodeparamfilter , 'TopTenSellingWiseSalesRep');
        echo json_encode($data);
      }
else
      {
          // $query = new MongoDB\Driver\Query($datefilter); 
          // $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSalesPerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          // echo json_encode($data);
        $data = executeBlock($datefilter , 'SalesRepWiseSalesPerformanceQtn');
        echo json_encode($data);
      }

      function executeBlock($queryVar,$collection){
        $rows = getData($queryVar,$collection);
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          return $data;
      }
?>
