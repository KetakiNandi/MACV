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
 $dateempcatfilterSession=array('SalesRepNameid'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateempcatpostypefilterSession=array('SalesRepNameid'=>$EmpIdname,'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CAT//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 
if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
 
  $result   =   executeBlock($datessitecatSRpostypefilterSession , 'datesourcesitecatpromopostypeemp');
  echo $result;
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
 
  $result   =   executeBlock($datessitecatpostypefilterSession , 'datesourcesitecatpromopostype');
  echo $result;
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
 
  $result   =   executeBlock($datessitecatSRfilterSession , 'DatesourcesitecatpromoEmpid');
  echo $result;
}
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{

  $result   =   executeBlock($datessitecatfilterSession , 'DateSourceSitePromoNameWiseCategorywisePerformanceQtn');
  echo $result;
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{

  $result   =   executeBlock($datecitycatSRpostypefilterSession , 'datecitycatpromopostypeemp');
  echo $result;
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{

  $result   =   executeBlock($datecitycatpostypefilterSession , 'datecitycatpromopostype');
  echo $result;
}
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{

  $result   =   executeBlock($datecitycatSRfilterSession , 'DatecitycatpromoEmpid');
  echo $result;
}

else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{

  $result   =   executeBlock($datecitycatfilterSession , 'DateCityPromoNameWiseCategorywisePerformanceQtn');
  echo $result;
}

else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  
  $result   =   executeBlock($datestatecatSRpostypefilterSession , 'datestatecatpromopostypeemp');
  echo $result;
}
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  
  $result   =   executeBlock($datestatecatpostypefilterSession , 'datestatecatpromopostype');
  echo $result;
}

else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  
  $result   =   executeBlock($datestatecatSRfilterSession , 'DatestatecatpromoEmpid');
  echo $result;
}
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  
  $result   =   executeBlock($datestatecatfilterSession , 'DateStatePromoNameWiseCategorywisePerformanceQtn');
  echo $result;
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
  
  $result   =   executeBlock($datezonecatSRpostypefilterSession , 'datezonecatpromopostypeemp');
  echo $result;
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  
  $result   =   executeBlock($datezonecatpostypefilterSession , 'datezonecatpromopostype');
  echo $result;
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  
  $result   =   executeBlock($datezonecatSRfilterSession , 'DatezonecatpromoEmpid');
  echo $result;
}
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  
  $result   =   executeBlock($datezonecatfilterSession , 'DateZonePromoNameWiseCategorywisePerformanceQtn');
  echo $result;
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  
  $result   =   executeBlock($dateempcatpostypefilterSession , 'datecatemppromopostype');
  echo $result;
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  
  $result   =   executeBlock($datecatpostypefilterSession , 'datecatpromopostype');
  echo $result;
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  
  $result   =   executeBlock($dateempcatfilterSession , 'DateEmpIdPromoNameWiseCategorywisePerformanceQtn');
  echo $result;
}
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  
  $result   =   executeBlock($datecatfilterSession , 'DateWisePromoWiseCategorywisePerformanceQtn');
  echo $result;
}
else if($startDate && $endDate)
{
  $result   =   executeBlock($datefilter , 'PromoNameWiseSalesPerformanceQtn');
  echo $result;
}
else if($POSTypeparam)
{
  $result   =   executeBlock($POSTypefilter , 'PosTypeWiseZSCSWisePromoName');
  echo $result;

}
else if($SubCatparamfilter['SubCategory'])
{
  $result   =   executeBlock($SubCatparamfilter , 'PromoNameWiseSubCatWisePerformanceQtn');
  echo $result;
}
else if($itemcodeparamfilter['Item_Code'])
{
 
    $result   =   executeBlock($itemcodeparamfilter , 'TopTenSellingWisePromoName');
  echo $result;
}
else
{
  
  $result   =   executeBlock($datefilter , 'PromoNameWiseSalesPerformanceQtn');
  echo $result;

}


function executeBlock($queryVar,$collection){

          $rows = getData($queryVar,$collection);
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
              
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1);
            } 
            else {
              $findCounter  = 0;
            }
          }

 $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities'],"stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          return json_encode($dataWithDateParam);
         // $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        

}

?>
