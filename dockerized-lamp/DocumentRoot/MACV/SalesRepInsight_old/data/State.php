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
//var_dump($zonename) ;
$str_explode=explode(",",$zonename);
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

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];

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

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

//echo "<pre>" ;print_r($zonefilter);
//die;

if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
      $result   =  executeBlock($datessitecatPromoPostypefilterSession , 'datestatesourcesitecatpostypepromo' );
      echo $result;
    }

else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
      $result   =  executeBlock($datessitecatSRPostypefilterSession , 'DateStateSourceSiteCatEmpPOS' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
      $result   =  executeBlock($datessiteSRpostypefilterSession , 'datestatesourcesitepostypeemp' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
      $result   =  executeBlock($datessitecatPostypefilterSession , 'datestatesourcesitecatpostype' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
      $result   =  executeBlock($datessitepostypefilterSession , 'datestatesourcesitecatpostype' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
      $result   =  executeBlock($datessitecatSRfilterSession , 'DateStateSourceSiteCatEmpPOS' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
      $result   =  executeBlock($datessiteSRfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
      $result   =  executeBlock($datessitecatpromofilterSession , 'datestatesourcesitecatpostypepromo' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
      $result   =  executeBlock($datessitecatfilterSession , 'datestatesourcesitecatpostype' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
      $result   =  executeBlock($datessitefilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }

/////
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
      $result   =  executeBlock($datecitycatpostypepromofilterSession , 'DateStateCityCatPromoPOS' );
      echo $result;
    }

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
      $result   =  executeBlock($datecitycatSRpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
      $result   =  executeBlock($datecitySRpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
      $result   =  executeBlock($datecitycatpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
      $result   =  executeBlock($datecitypostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
      $result   =  executeBlock($datecitycatSRfilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
      $result   =  executeBlock($datecitySRfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
      $result   =  executeBlock($datecitycatpromofilterSession , 'DateStateCityCatPromoPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
      $result   =  executeBlock($datecitycatfilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
      $result   =  executeBlock($datecityfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
      $result   =  executeBlock($datezonecatpostypepromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS' );
      echo $result;
    }

else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
      $result   =  executeBlock($datezonecatSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  $result   =  executeBlock($datezoneSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  $result   =  executeBlock($datezonecatpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  $result   =  executeBlock($datezonepostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  $result   =  executeBlock($datezonecatSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
  $result   =  executeBlock($datezoneSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  $result   =  executeBlock($datezonecatpromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  $result   =  executeBlock($datezonecatfilterSession , 'DateZoneWiseStateWiseCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  $result   =  executeBlock($datezonefilterSession , 'DateZoneWiseState' );
      echo $result;
    }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam && $Promoname)
  {
      $result   =  executeBlock($dateempcatpostypepromofilterSession , 'datestatecatpromopostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
  {
      $result   =  executeBlock($dateempcatpostypefilterSession , 'DateStateSourceSiteCatEmpPOS' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
      $result   =  executeBlock($dateemppostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
  {
      $result   =  executeBlock($dateempcatpromofilterSession , 'datestatecatpromopostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
  {
      $result   =  executeBlock($dateempcatfilterSession , 'datestatecatpostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
      $result   =  executeBlock($dateempfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
      $result   =  executeBlock($datecatpostypepromofilterSession , 'datestatecatpromopostype' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    $result   =  executeBlock($datecatpromofilterSession , 'datestatecatpromopostype' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    $result   =  executeBlock($datecatpostypefilterSession , 'datestatecatpostypeemp' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result   =  executeBlock($datecatfilterSession , 'datestatecatpromopostype' );
      echo $result;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
      $result   =  executeBlock($datepostypefilterSession , 'datestatecatpromopostype' );
      echo $result;
  }
else if($startDate && $endDate)
 {
  $result   =  executeBlock($datefilter , 'DateWiseStateWiseSalesPerformanceQtn' );
      echo $result;
         }

else if($SubCatparamfilter['SubCategory'])
    {
      $result   =  executeBlock($SubCatparamfilter , 'StateWiseSubCatWisePerformanceQtn' );
      echo $result;
    }     
    else if($itemcodeparamfilter['Item_Code'])
    {
      $result   =  executeBlock($itemcodeparamfilter , 'TopTenSellingWiseState' );
      echo $result;
    }     
else 
{
      $result   =  executeBlock($datefilter , 'DateWiseStateWiseSalesPerformanceQtn' );
      echo $result; 
        }

  function executeBlock($queryVar,$collection){

          $rows = getData($queryVar,$collection);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["State"]==trim($row->State)){
    
     $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+1;            
                break;
              }
            }
            if($findCounter==0){
              
              $data[$i]     =  array("State"=>trim($row->State),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }

return json_encode($data);
}

?>