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

 //$param = $_GET['param'];
 $statename = $_SESSION['states'];
 $str_explodeState=explode(",",$statename);
 $Cityname = $_SESSION['cities'];
 $str_explodeCity=explode(",",$Cityname);
 $EmpIdname = $_SESSION['EMP'];
 $Sitename = $_SESSION['Sites'];
 $str_explodeSite=explode(",",$Sitename);
 $categoryname = $_SESSION['Categories'];
 $str_explodeCatgory=explode(",",$categoryname);
 $Promoname = $_SESSION['ProNames'];
 $str_explodePromo=explode(",",$Promoname);
$POSTypeparam = $_SESSION['POSTypes'];
$str_explodePOSType=explode(",",$POSTypeparam);
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17

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

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);


/////////EMP///////////
 //$Empfilter['SalespersonId'] = $EmpIdname;
 $dateempfilterSession=array('SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateempcatfilterSession=array('SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpromofilterSession=array('SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateemppostypefilterSession=array('SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpostypefilterSession=array('SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpostypepromofilterSession=array('SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatpostypepromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessiteSRpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatPromoPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypepromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypepromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

//$Empfilter['SalespersonId'] = $EmpIdname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

/*$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));*/

if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatPromoPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostypepromo", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatPromoPostypefilterSession , 'datezonesourcesitecatpostypepromo' );
    echo $data;
    }

else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneSourceSiteCatEmpPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatSRPostypefilterSession , 'DateZoneSourceSiteCatEmpPOS' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessiteSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitepostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessiteSRpostypefilterSession , 'datezonesourcesitepostypeemp' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessitecatPostypefilterSession , 'datezonesourcesitecatpostype' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessitepostypefilterSession , 'datezonesourcesitecatpostype' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneSourceSiteCatEmpPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessitecatSRfilterSession , 'DateZoneSourceSiteCatEmpPOS' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessiteSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessiteSRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datessitecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostypepromo", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatpromofilterSession , 'datezonesourcesitecatpostypepromo' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datessitecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatfilterSession , 'datezonesourcesitecatpostype' );
    echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datessitefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitefilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
    echo $data;
    }

/////
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitycatpostypepromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatpostypepromofilterSession , 'DateZoneCityCatPromoPOS' );
    echo $data;
    }

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitycatSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatSRpostypefilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitySRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitySRpostypefilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitycatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatpostypefilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datecitypostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitypostypefilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datecitycatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatSRfilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datecitySRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitySRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datecitycatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatpromofilterSession , 'DateZoneCityCatPromoPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datecitycatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecitycatfilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datecityfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datecityfilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
    echo $data;
    }

////
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatpostypepromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatpostypepromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS' );
    echo $data;
    }

else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestateSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestateSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datestatecatpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatepostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestateSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestateSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datestatecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatpromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datestatecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseStateWiseCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
    echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datestatefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneWiseState", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datestatefilterSession , 'DateZoneWiseState' );
    echo $data;
    }
///////
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam && $Promoname)
  {
 //    $query = new MongoDB\Driver\Query($dateempcatpostypepromofilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostypeemp", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
    $data = executeBlock($dateempcatpostypepromofilterSession , 'datezonecatpromopostypeemp' );
    echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
  {
 //    $query = new MongoDB\Driver\Query($dateempcatpostypefilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.DateZoneSourceSiteCatEmpPOS", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
     $data = executeBlock($dateempcatpostypefilterSession , 'DateZoneSourceSiteCatEmpPOS' );
    echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
 //    $query = new MongoDB\Driver\Query($dateemppostypefilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
     $data = executeBlock($dateemppostypefilterSession , 'DateZoneCityCatSRPOS' );
    echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
  {
 //    $query = new MongoDB\Driver\Query($dateempcatpromofilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostypeemp", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
    $data = executeBlock($dateempcatpromofilterSession , 'datezonecatpromopostypeemp' );
    echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
  {
 //    $query = new MongoDB\Driver\Query($dateempcatfilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpostypeemp", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
    $data = executeBlock($dateempcatfilterSession , 'datezonecatpostypeemp' );
    echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
	//echo "<pre>"; print_r($EmpIdname);die;
 //    $query = new MongoDB\Driver\Query($dateempfilterSession); 

 //          $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);  //collections zone state souceSite saleRepname

	// $result = array();
 //          foreach($rows as $row){
 //              for($i=0;$i<count($data);$i++){
 //              if($data[$i]["Zone"]==trim($row->Zone)){          
 //                $findCounter    = 1;
 //                $oldV           = $data[$i]["count"];
 //                $data[$i]["count"]    = $oldV+1;          
 //                break;
 //              }
 //            }
 //            if($findCounter==0){
 //              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
 //            } 
 //            else {
 //              $findCounter  = 0;
 //            }
 //          }
 //          echo json_encode($data);
     $data = executeBlock($dateempfilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
    echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypepromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["Zone"]==trim($row->Zone)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypepromofilterSession , 'datezonecatpromopostype' );
    echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["Zone"]==trim($row->Zone)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
     $data = executeBlock($datecatpromofilterSession , 'datezonecatpromopostype' );
    echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpostypeemp", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["Zone"]==trim($row->Zone)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypefilterSession , 'datezonecatpostypeemp' );
    echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecatfilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["Zone"]==trim($row->Zone)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatfilterSession , 'datezonecatpromopostype' );
    echo $data;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datepostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["Zone"]==trim($row->Zone)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
     $data = executeBlock($datepostypefilterSession , 'datezonecatpromopostype' );
    echo $data;
  }
///////
else if($startDate && $endDate)
{
  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datefilter , 'DateWiseZoneWiseSalesPerformanceQtn' );
    echo $data;
    }


else if($SubCatparamfilter['SubCategory'])

{
  // $query = new MongoDB\Driver\Query($SubCatparamfilter); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseSubCatWisePerformanceQtn", $query); //category collections
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($SubCatparamfilter , 'ZoneWiseSubCatWisePerformanceQtn' );
    echo $data;
    }


else if($itemcodeparamfilter['Item_Code'])

{
  // $query = new MongoDB\Driver\Query($itemcodeparamfilter); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWiseZone", $query); //Promo Name collections

  //          // print_r($rows);

  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($itemcodeparamfilter , 'TopTenSellingWiseZone' );
    echo $data;
    }
else
{

  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["Zone"]==trim($row->Zone)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($datefilter , 'DateWiseZoneWiseSalesPerformanceQtn' );
    echo $data;
    }

    function executeBlock($queryVar,$collection){
      $rows = getData($queryVar,$collection);
      $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Zone"]==trim($row->Zone)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Zone"=>trim($row->Zone),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          return json_encode($data);
    }


?>
