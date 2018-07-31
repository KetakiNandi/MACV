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
    $_SESSION['endDate'] =  "31-Mar-18";
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
   
  $result   =   executeBlock($datecitycatpostypepromofilterSession , 'datecitysourcesitecatpostypeprom');
  echo $result;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
  {
  
  $result   =   executeBlock($datecitycatpostypefilterSession , 'datecitysourcesitecatpostype');
  echo $result;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
  {
       $result   =   executeBlock($datecitySRpostypefilterSession , 'datecitysourcesitepostypeemp');
  echo $result;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    $result   =   executeBlock($datecitypostypefilterSession , 'DateCityPosTypeWisePoSTargetAchievement');
  echo $result;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
  $result   =   executeBlock($datecityfilterSession , 'DateWiseCityWisePoSTargetAchievement');
  echo $result;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname && $Promoname)
  {
  $result   =   executeBlock($datestatecatpostypepromofilterSession , 'datestatesourcesitecatpostypepromo');
  echo $result;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
  {
     $result   =   executeBlock($datestatecatpostypefilterSession , 'datestatesourcesitecatpostype');
  echo $result;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
  {
   
  $result   =   executeBlock($datestateSRpostypefilterSession , 'datestatesourcesitepostypeemp');
  echo $result;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
  $result   =   executeBlock($datestatepostypefilterSession , 'DateStatePosTypeWisePoSTargetAchievement');
  echo $result;
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result   =   executeBlock($datestatefilterSession , 'DateWiseStateWisePoSTargetAchievement');
  echo $result;
  }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname && $Promoname)
{
  $result   =   executeBlock($datezonecatpostypepromofilterSession , 'datezonesourcesitecatpostypepromo');
  echo $result;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $categoryname)
{
       $result   =   executeBlock($datezonecatpostypefilterSession , 'datezonesourcesitecatpostype');
  echo $result;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $EmpIdname)
{
   $result   =   executeBlock($datezoneSRpostypefilterSession , 'datezonesourcesitepostypeemp');
  echo $result;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  $result   =   executeBlock($datezonepostypefilterSession , 'DateZonePosTypeWisePoSTargetAchievement');
  echo $result;
      }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
    $result   =   executeBlock($datezonefilterSession , 'DateWiseZoneWisePoSTargetAchievement');
    echo $result;
      }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    $result   =   executeBlock($dateemppostypefilterSession , 'datesourcesiteempidpostype');
    echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result   =   executeBlock($dateempfilterSession , 'DateWiseEmpIdWisePoSTargetAchievement');
    echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
  $result   =   executeBlock($datecatpostypepromofilterSession , 'datesourcesitecatpromopostype');
  echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
  $result   =   executeBlock($datecatpromofilterSession , 'DatePromoCategoryWisePoSTargetAchievement');
  echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
  $result   =   executeBlock($datecatpostypefilterSession , 'DateCategoryPosTypeWisePoSTargetAchievement');
  echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
       $result   =   executeBlock($datecatfilterSession , 'DateWiseCategoryWisePoSTargetAchievement');
  echo $result;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
     $result   =   executeBlock($datepostypefilterSession , 'DateCategoryPosTypeWisePoSTargetAchievement');
  echo $result;
  }
else if($startDate && $endDate)
{
   $result   =   executeBlock($datefilter , 'DateWiseSourceSiteWiseSalesPerformanceQtn');
  echo $result;
      }
else if($SubCatparamfilter['SubCategory'])
  {
    $result   =   executeBlock($SubCatparamfilter , 'SourceSiteSubCatWisePerformanceQtn');
  echo $result;
  }
else if($itemcodeparamfilter['Item_Code'])
  {
    $result   =   executeBlock($itemcodeparamfilter , 'TopTensellingWiseSalespersonWiseContributionValue');
  echo $result;
  }

else
{

  $result   =   executeBlock($datefilter , 'DateWiseSourceSiteWiseSalesPerformanceQtn');
  echo $result;

    }


        function executeBlock($queryVar,$collection){
            $rows         =   getData($queryVar,$collection);
            $result       =   array();
            $data         =   array();
            $findCounter;
            foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
                if($data[$i]["SourceSite"]==trim($row->SourceSite)){
                  $findCounter               = 1;
                  $oldV                      = $data[$i]["count"];
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

      return json_encode($data);
    }
?>
