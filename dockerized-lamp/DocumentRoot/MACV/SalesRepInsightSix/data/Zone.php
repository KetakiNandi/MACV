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
    $_SESSION['endDate'] =   "31-Mar-18";
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
 $str_explodeEmpId=explode(",",$EmpIdname);
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
 //$Empfilter['SalespersonId'] = $EmpIdname;
 $dateempfilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateempcatfilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpromofilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateemppostypefilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpostypefilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempcatpostypepromofilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

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
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessiteSRpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitecatPromoPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypepromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRpostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypepromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRpostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
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
  
          $result = executeBlock($datessitecatPromoPostypefilterSession , 'datezonesourcesitecatpostypepromo');
                      echo $result;
    }

else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
  
          $result = executeBlock($datessitecatSRPostypefilterSession , 'DateZoneSourceSiteCatEmpPOS');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
          $result = executeBlock($datessiteSRpostypefilterSession , 'datezonesourcesitepostypeemp');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
          $result = executeBlock($datessitecatPostypefilterSession , 'datezonesourcesitecatpostype');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
          $result = executeBlock($datessitepostypefilterSession , 'datezonesourcesitecatpostype');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
          $result = executeBlock($datessitecatSRfilterSession , 'DateZoneSourceSiteCatEmpPOS');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
          $result = executeBlock($datessiteSRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
          $result = executeBlock($datessitecatpromofilterSession , 'datezonesourcesitecatpostypepromo');
                      echo $result;

    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
          $result = executeBlock($datessitecatfilterSession , 'datezonesourcesitecatpostype');
                      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
           $result = executeBlock($datessitefilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
                      echo $result;
    }


else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
           $result = executeBlock($datecitycatpostypepromofilterSession , 'DateZoneCityCatPromoPOS');
                      echo $result;
    }

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
          $result = executeBlock($datecitycatSRpostypefilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
          $result = executeBlock($datecitySRpostypefilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
    
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
          $result = executeBlock($datecitycatpostypefilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
          $result = executeBlock($datecitypostypefilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
          $result = executeBlock($datecitycatSRfilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
          $result = executeBlock($datecitySRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
          $result = executeBlock($datecitycatpromofilterSession , 'DateZoneCityCatPromoPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
          $result = executeBlock($datecitycatfilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
    }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
          $result = executeBlock($datecityfilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
                      echo $result;
    }


else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
          $result = executeBlock($datestatecatpostypepromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS');
                      echo $result;
    }

else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
          $result = executeBlock($datestatecatSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
           $result = executeBlock($datestateSRpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
          $result = executeBlock($datestatecatpostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
           $result = executeBlock($datestatepostypefilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
    
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
          $result = executeBlock($datestatecatSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
    
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
          $result = executeBlock($datestateSRfilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
          $result = executeBlock($datestatecatpromofilterSession , 'DateZoneWiseStateWiseCatPromoPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
          $result = executeBlock($datestatecatfilterSession , 'DateZoneWiseStateWiseCatSRPOS');
                      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
          $result = executeBlock($datestatefilterSession , 'DateZoneWiseState');
                      echo $result;
    }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam && $Promoname)
  {
          $result = executeBlock($dateempcatpostypepromofilterSession , 'datezonecatpromopostypeemp');
                      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
  {
          $result = executeBlock($dateempcatpostypefilterSession , 'DateZoneSourceSiteCatEmpPOS');
                      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
          $result = executeBlock($dateemppostypefilterSession , 'DateZoneCityCatSRPOS');
                      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
  {
    
          $result = executeBlock($dateempcatpromofilterSession , 'datezonecatpromopostypeemp');
                      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
  {
          $result = executeBlock($dateempcatfilterSession , 'datezonecatpostypeemp');
                      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
          $result = executeBlock($dateempfilterSession , 'DateWiseZoneWiseSRWiseContributionValue');
                      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
          $result = executeBlock($datecatpostypepromofilterSession , 'datezonecatpromopostype');
                      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
          $result = executeBlock($datecatpromofilterSession , 'datezonecatpromopostype');
                      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
          $result = executeBlock($datecatpostypefilterSession , 'datezonecatpostypeemp');
                      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
          $result = executeBlock($datecatfilterSession , 'datezonecatpromopostype');
                      echo $result;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
          $result = executeBlock($datepostypefilterSession , 'datezonecatpromopostype');
                      echo $result;
  }

else if($startDate && $endDate)
{
          $result = executeBlock($datefilter , 'DateWiseZoneWiseSalesPerformanceQtn');
                      echo $result;
    }


else if($SubCatparamfilter['SubCategory'])

{
  
          $result = executeBlock($SubCatparamfilter , 'ZoneWiseSubCatWisePerformanceQtn');
                      echo $result;
    }


else if($itemcodeparamfilter['Item_Code'])

{
  
          $result = executeBlock($itemcodeparamfilter , 'TopTenSellingWiseZone');
                      echo $result;
    }
else
{

  
          $result = executeBlock($datefilter , 'DateWiseZoneWiseSalesPerformanceQtn');
                      echo $result;
    }


        function executeBlock($queryVar,$collection){
            $rows     =   getData($queryVar,$collection);
            $result   =   array();
            $data     =   array();
            $findCounter;
            
            foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
                if($data[$i]["Zone"]==trim($row->Zone)){
                  $findCounter               = 1;
                  $oldV                      = $data[$i]["count"];
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