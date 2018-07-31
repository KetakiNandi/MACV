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
  $zonename = $_SESSION['zones'];
  $str_explode=explode(",",$zonename);
  $statename = $_SESSION['states'];
  $str_explodeState=explode(",",$statename);
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
 
 
 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explode),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatpostypepromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezoneSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $statename;
//$Empfilter['SalespersonId'] = $EmpIdname;
//$Sitefilter['SourceSite'] = $Sitename;
//$catefilter['Category'] = $categoryname;
//$promoNamefilter['PromoNo'] = $Promoname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;
/*$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));*/


if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatPromoPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostypepromo", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatPromoPostypefilterSession , 'datecitysourcesitecatpostypepromo');
          echo $data;
    }

else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateCitySourceSiteCatEmpPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatSRPostypefilterSession , 'DateCitySourceSiteCatEmpPOS');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessiteSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitepostypeemp", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessiteSRpostypefilterSession , 'datecitysourcesitepostypeemp');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitecatPostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateCitySourceSiteCatEmpPOS", $query);
  //          $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatPostypefilterSession , 'DateCitySourceSiteCatEmpPOS');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datessitepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostype", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitepostypefilterSession , 'datecitysourcesitecatpostype');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessitecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateCitySourceSiteCatEmpPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatSRfilterSession , 'DateCitySourceSiteCatEmpPOS');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datessiteSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessiteSRfilterSession , 'DateWiseStateWiseSRWiseContributionValue');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datessitecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostypepromo", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datessitecatpromofilterSession , 'datecitysourcesitecatpostypepromo');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datessitecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostype", $query);
  //          $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitecatfilterSession , 'datecitysourcesitecatpostype');
          echo $data;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datessitefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datessitefilterSession , 'DateWiseStateWiseSRWiseContributionValue');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatpostypepromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatpostypepromofilterSession , 'DateStateCityCatPromoPOS');
          echo $data;
    }

else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatSRpostypefilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestateSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestateSRpostypefilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatecatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatpostypefilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datestatepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //       $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatepostypefilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestatecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datestatecatSRfilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datestateSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestateSRfilterSession , 'DateWiseStateWiseSRWiseContributionValue');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datestatecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatPromoPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatpromofilterSession , 'DateStateCityCatPromoPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datestatecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatecatfilterSession , 'DateStateCityCatSRPOS');
          echo $data;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datestatefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datestatefilterSession , 'DateWiseStateWiseSRWiseContributionValue');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezonecatpostypepromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatPromoPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonecatpostypepromofilterSession , 'DateZoneCityCatPromoPOS');
          echo $data;
    }

else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezonecatSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonecatSRpostypefilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezoneSRpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezoneSRpostypefilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezonecatpostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonecatpostypefilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  // $query = new MongoDB\Driver\Query($datezonepostypefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonepostypefilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datezonecatSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
   $data = executeBlock($datezonecatSRfilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  // $query = new MongoDB\Driver\Query($datezoneSRfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezoneSRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  // $query = new MongoDB\Driver\Query($datezonecatpromofilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatPromoPOS", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonecatpromofilterSession , 'DateZoneCityCatPromoPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  // $query = new MongoDB\Driver\Query($datezonecatfilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateZoneCityCatSRPOS", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonecatfilterSession , 'DateZoneCityCatSRPOS');
          echo $data;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  // $query = new MongoDB\Driver\Query($datezonefilterSession); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSRWiseContributionValue", $query);
  //        $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datezonefilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
          echo $data;
    }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam && $Promoname)
  {
  //   $query = new MongoDB\Driver\Query($dateempcatpostypepromofilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostypeemp", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($dateempcatpostypepromofilterSession , 'datecitycatpromopostypeemp');
          echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
  {
  //   $query = new MongoDB\Driver\Query($dateempcatpostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateCitySourceSiteCatEmpPOS", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($dateempcatpostypefilterSession , 'DateCitySourceSiteCatEmpPOS');
          echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
  //   $query = new MongoDB\Driver\Query($dateemppostypefilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateStateCityCatSRPOS", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($dateemppostypefilterSession , 'DateStateCityCatSRPOS');
          echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
  {
  //   $query = new MongoDB\Driver\Query($dateempcatpromofilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostypeemp", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($dateempcatpromofilterSession , 'datecitycatpromopostypeemp');
          echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
  {
  //   $query = new MongoDB\Driver\Query($dateempcatfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpostypeemp", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
     $data = executeBlock($dateempcatfilterSession , 'datecitycatpostypeemp');
          echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
  //   $query = new MongoDB\Driver\Query($dateempfilterSession); 

  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSRWiseContributionValue", $query);  //collections zone state souceSite saleRepname

	 // $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["CIty"]==trim($row->City)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
    $data = executeBlock($dateempfilterSession , 'DateWiseStateWiseSRWiseContributionValue');
          echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypepromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query); //category collections
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypepromofilterSession , 'datecitycatpromopostype');
          echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query); //category collections
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpromofilterSession , 'datecitycatpromopostype');
          echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpostypeemp", $query); //category collections
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypefilterSession , 'datecitycatpostypeemp');
          echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecatfilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatfilterSession , 'datecitycatpromopostype');
          echo $data;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datepostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query); //category collections
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datepostypefilterSession , 'datecitycatpromopostype');
          echo $data;
  }
else if($startDate && $endDate)
  {
    // $query = new MongoDB\Driver\Query($datefilter); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWiseSalesPerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datefilter , 'DateWiseCityWiseSalesPerformanceQtn');
          echo $data;
        }

else if($SubCatparamfilter['SubCategory'])
  {
   // $query = new MongoDB\Driver\Query($SubCatparamfilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        // $rows  = $connection->executeQuery("SaleRepInsight.CityWiseSubCatWisePerformanceQtn", $query); //PromoName collections

        //   $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["CIty"]==trim($row->City)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
        //   echo json_encode($data);
    $data = executeBlock($SubCatparamfilter , 'CityWiseSubCatWisePerformanceQtn');
          echo $data;
  }
  else if($itemcodeparamfilter['Item_Code'])
  {
    // $query = new MongoDB\Driver\Query($itemcodeparamfilter); 

    //      // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

    //     $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWiseCity", $query); //PromoName collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
     $data = executeBlock($itemcodeparamfilter , 'TopTenSellingWiseCity');
          echo $data;
  }
else
    {
    // $query = new MongoDB\Driver\Query($datefilter); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWiseSalesPerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["CIty"]==trim($row->City)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
          $data = executeBlock($datefilter , 'DateWiseCityWiseSalesPerformanceQtn');
          echo $data;

    }

    function executeBlock($queryVar,$collection){
      $rows = getData($queryVar,$collection);
      $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          return json_encode($data);
    }
?>
