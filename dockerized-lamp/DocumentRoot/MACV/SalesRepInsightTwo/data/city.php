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
 
 
 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explode),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezonecatpostypepromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datezoneSRpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

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
 
  $result = executeBlock($datessitecatPromoPostypefilterSession , 'datecitysourcesitecatpostypepromo' );
      echo $result;
    }

else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
    $result = executeBlock($datessitecatSRPostypefilterSession , 'DateCitySourceSiteCatEmpPOS' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  $result = executeBlock($datessiteSRpostypefilterSession , 'datecitysourcesitepostypeemp' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  $result = executeBlock($datessitecatPostypefilterSession , 'DateCitySourceSiteCatEmpPOS' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
   $result = executeBlock($datessitepostypefilterSession , 'datecitysourcesitecatpostype' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
  $result = executeBlock($datessitecatSRfilterSession , 'DateCitySourceSiteCatEmpPOS' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
   $result = executeBlock($datessiteSRfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{

   $result = executeBlock($datessitecatpromofilterSession , 'datecitysourcesitecatpostypepromo' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  $result = executeBlock($datessitecatfilterSession , 'datecitysourcesitecatpostype' );
      echo $result;
    }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
   $result = executeBlock($datessitefilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
  $result = executeBlock($datestatecatpostypepromofilterSession , 'DateStateCityCatPromoPOS' );
      echo $result;
    }

else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
   $result = executeBlock($datestatecatSRpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
  $result = executeBlock($datestateSRpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
        $result = executeBlock($datestatecatpostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
      $result = executeBlock($datestatepostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
          $result = executeBlock($datestatecatSRfilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
        $result = executeBlock($datestateSRfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
      $result = executeBlock($datestatecatpromofilterSession , 'DateStateCityCatPromoPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
             $result = executeBlock($datestatecatfilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
    }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
           $result = executeBlock($datestatefilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname && $POSTypeparam)
{
         $result = executeBlock($datezonecatpostypepromofilterSession , 'DateZoneCityCatPromoPOS' );
      echo $result;
    }

else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname && $POSTypeparam)
{
          $result = executeBlock($datezonecatSRpostypefilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam)
{
        $result = executeBlock($datezoneSRpostypefilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
      $result = executeBlock($datezonecatpostypefilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
          $result = executeBlock($datezonepostypefilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $EmpIdname)
{
        $result = executeBlock($datezonecatSRfilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
{
      $result = executeBlock($datezoneSRfilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
        $result = executeBlock($datezonecatpromofilterSession , 'DateZoneCityCatPromoPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
      $result = executeBlock($datezonecatfilterSession , 'DateZoneCityCatSRPOS' );
      echo $result;
    }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
        $result = executeBlock($datezonefilterSession , 'DateWiseZoneWiseSRWiseContributionValue' );
      echo $result;
    }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam && $Promoname)
  {
  
      $result = executeBlock($dateempcatpostypepromofilterSession , 'datecitycatpromopostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
  {
      $result = executeBlock($dateempcatpostypefilterSession , 'DateCitySourceSiteCatEmpPOS' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
      $result = executeBlock($dateemppostypefilterSession , 'DateStateCityCatSRPOS' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
  {
         $result = executeBlock($dateempcatpromofilterSession , 'datecitycatpromopostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
  {
     $result = executeBlock($dateempcatfilterSession , 'datecitycatpostypeemp' );
      echo $result;
  }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result = executeBlock($dateempfilterSession , 'DateWiseStateWiseSRWiseContributionValue' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname)
  {
    $result = executeBlock($datecatpostypepromofilterSession , 'datecitycatpromopostype' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    $result = executeBlock($datecatpromofilterSession , 'datecitycatpromopostype' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
  {
    $result = executeBlock($datecatpostypefilterSession , 'datecitycatpostypeemp' );
      echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result = executeBlock($datecatfilterSession , 'datecitycatpromopostype' );
      echo $result;
  }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result = executeBlock($datepostypefilterSession , 'datecitycatpromopostype' );
      echo $result;
  }
else if($startDate && $endDate)
  {
    $result = executeBlock($datefilter , 'DateWiseCityWiseSalesPerformanceQtn' );
      echo $result;
        }

else if($SubCatparamfilter['SubCategory'])
  {
    $result = executeBlock($SubCatparamfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName' );
      echo $result;
  }
  else if($itemcodeparamfilter['Item_Code'])
  {
    $result = executeBlock($itemcodeparamfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName' );
      echo $result;
  }
else
    {
      $result = executeBlock($datefilter , 'DateWiseCityWiseSalesPerformanceQtn' );
      echo $result;

    }


            function executeBlock($queryVar,$collection){
            $rows     =   getData($queryVar,$collection);
            $result   =   array();
            $data     =   array();
            $findCounter;
            
            foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
                if($data[$i]["CIty"]==trim($row->City)){
                  $findCounter               = 1;
                  $oldV                      = $data[$i]["count"];
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

	$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

	return json_encode($dataWithDateParam);
      //return json_encode($data);
    }
?>
