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
$categoryname = $_SESSION['Categories'];
$str_explodeCatgory=explode(",",$categoryname);
$EmpIdname = $_SESSION['EMP'];
$str_explodeEmpId=explode(",",$EmpIdname);
$Promoname = $_SESSION['ProNames'];
$str_explodePromo=explode(",",$Promoname);
$Sitename = $_SESSION['Sites'];
$POSTypeparam = $_SESSION['POSTypes'];
$str_explodePOSType=explode(",",$POSTypeparam);
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17


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

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

/////////EMP///////////
 //$Empfilter['SalesRepNameid'] = $EmpIdname;
 $dateempfilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateemppostypefilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatpostypepromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 
 
 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitySRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypepromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestateSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypepromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 
 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explode),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezoneSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSType));
 $datezonecatpostypepromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSType),'PromoNo'=>array('$in'=>$str_explodePromo));

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecitycatpostypepromofilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostypeprom", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecitycatpostypepromofilterSession , 'datecitysourcesitecatpostypeprom' );
  echo $data;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
  {
    // $query = new MongoDB\Driver\Query($datecitycatpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitecatpostype", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecitycatpostypefilterSession , 'datecitysourcesitecatpostype' );
  echo $data;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datecitySRpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datecitysourcesitepostypeemp", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecitySRpostypefilterSession , 'datecitysourcesitepostypeemp' );
  echo $data;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query($datecitypostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateCityPosTypeWisePoSTargetAchievement", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecitypostypefilterSession , 'DateCityPosTypeWisePoSTargetAchievement' );
  echo $data;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecityfilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWisePoSTargetAchievement", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecityfilterSession , 'DateWiseCityWisePoSTargetAchievement' );
  echo $data;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datestatecatpostypepromofilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datestatesourcesitecatpostypepromo", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datestatecatpostypepromofilterSession , 'datestatesourcesitecatpostypepromo' );
  echo $data;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
  {
    // $query = new MongoDB\Driver\Query($datestatecatpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datestatesourcesitecatpostype", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datestatecatpostypefilterSession , 'datestatesourcesitecatpostype' );
  echo $data;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datestateSRpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datestatesourcesitepostypeemp", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datestateSRpostypefilterSession , 'datestatesourcesitepostypeemp' );
  echo $data;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query($datestatepostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateStatePosTypeWisePoSTargetAchievement", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datestatepostypefilterSession , 'DateStatePosTypeWisePoSTargetAchievement' );
  echo $data;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datestatefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWisePoSTargetAchievement", $query);


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datestatefilterSession , 'DateWiseStateWisePoSTargetAchievement' );
  echo $data;
  }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname && $Promoname)
{
    // $query = new MongoDB\Driver\Query($datezonecatpostypepromofilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostypepromo", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
  $data = executeBlock($datezonecatpostypepromofilterSession , 'datezonesourcesitecatpostypepromo' );
  echo $data;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
{
    // $query = new MongoDB\Driver\Query($datezonecatpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitecatpostype", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
   $data = executeBlock($datezonecatpostypefilterSession , 'datezonesourcesitecatpostype' );
  echo $data;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
    // $query = new MongoDB\Driver\Query($datezoneSRpostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datezonesourcesitepostypeemp", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
  $data = executeBlock($datezoneSRpostypefilterSession , 'datezonesourcesitepostypeemp' );
  echo $data;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
    // $query = new MongoDB\Driver\Query($datezonepostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateZonePosTypeWisePoSTargetAchievement", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
  $data = executeBlock($datezonepostypefilterSession , 'DateZonePosTypeWisePoSTargetAchievement' );
  echo $data;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
    // $query = new MongoDB\Driver\Query($datezonefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWisePoSTargetAchievement", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
  $data = executeBlock($datezonefilterSession , 'DateWiseZoneWisePoSTargetAchievement' );
  echo $data;
      }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query( $dateemppostypefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datesourcesiteempidpostype", $query);  //collections zone state souceSite saleRepname


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($dateemppostypefilterSession , 'datesourcesiteempidpostype' );
  echo $data;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($dateempfilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWisePoSTargetAchievement", $query);  //collections zone state souceSite saleRepname


    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($dateempfilterSession , 'DateWiseEmpIdWisePoSTargetAchievement' );
  echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypepromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.datesourcesitecatpromopostype", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypepromofilterSession , 'datesourcesitecatpromopostype' );
  echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpromofilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.DatePromoCategoryWisePoSTargetAchievement", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpromofilterSession , 'DatePromoCategoryWisePoSTargetAchievement' );
  echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    // $query = new MongoDB\Driver\Query($datecatpostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.DateCategoryPosTypeWisePoSTargetAchievement", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatpostypefilterSession , 'DateCategoryPosTypeWisePoSTargetAchievement' );
  echo $data;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecatfilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.DateWiseCategoryWisePoSTargetAchievement", $query); //category collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datecatfilterSession , 'DateWiseCategoryWisePoSTargetAchievement' );
  echo $data;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datepostypefilterSession); 
    //   $rows  = $connection->executeQuery("SaleRepInsight.DateCategoryPosTypeWisePoSTargetAchievement", $query); //category collections
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datepostypefilterSession , 'DateCategoryPosTypeWisePoSTargetAchievement' );
  echo $data;
  }
else if($startDate && $endDate)
{
    // $query = new MongoDB\Driver\Query($datefilter); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWiseSalesPerformanceQtn", $query);
           
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
  $data = executeBlock($datefilter , 'DateWiseSourceSiteWiseSalesPerformanceQtn' );
  echo $data;
      }
else if($SubCatparamfilter['SubCategory'])
  {
    // $query = new MongoDB\Driver\Query( $SubCatparamfilter); 
    // $rows  = $connection->executeQuery("SaleRepInsight.SourceSiteSubCatWisePerformanceQtn", $query); //PromoName collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($SubCatparamfilter , 'SourceSiteSubCatWisePerformanceQtn' );
  echo $data;
  }
else if($itemcodeparamfilter['Item_Code'])
  {
    // $query = new MongoDB\Driver\Query( $itemcodeparamfilter); 
    // $rows  = $connection->executeQuery("SaleRepInsight.TopTensellingWiseSalespersonWiseContributionValue", $query); //PromoName collections
    //      $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($itemcodeparamfilter , 'TopTensellingWiseSalespersonWiseContributionValue' );
  echo $data;
  }

else
{

  // $query = new MongoDB\Driver\Query($datefilter); 
  //         $rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWiseSalesPerformanceQtn", $query);
  //         $result = array();
  //         foreach($rows as $row){
  //             for($i=0;$i<count($data);$i++){
  //             if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
  //               $findCounter    = 1;
  //               $oldV           = $data[$i]["count"];
  //               $data[$i]["count"]    = $oldV+1;          
  //               break;
  //             }
  //           }
  //           if($findCounter==0){
  //             $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
  //           } 
  //           else {
  //             $findCounter  = 0;
  //           }
  //         }
  //         echo json_encode($data);
  $data = executeBlock($datefilter , 'DateWiseSourceSiteWiseSalesPerformanceQtn' );
  echo $data;
    }

    function executeBlock($queryVar,$collection){
          $rows  = getData($queryVar,$collection);
          $data = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
	$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);
	return json_encode($dataWithDateParam);
    }
?>
