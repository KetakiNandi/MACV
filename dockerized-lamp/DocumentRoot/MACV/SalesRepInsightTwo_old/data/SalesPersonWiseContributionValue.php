<?php
require_once(__DIR__.'/config.php');
$database = "SaleRepInsight.";
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
 $Sitename = $_SESSION['Sites'];
 $str_explodeSite=explode(",",$Sitename);
 $POSTypeparam = $_SESSION['POSTypes'];
 $str_explodePOSSession=explode(",",$POSTypeparam);
 $startDate = $_SESSION['stDate'];//01-Jan-17
 $endDate = $_SESSION['endDate'];//31-Jan-17
 $categoryname = $_SESSION['Categories'];
 $str_explodeCatgory=explode(",",$categoryname);
 $Promoname = $_SESSION['ProNames'];
 $str_explodePromo=explode(",",$Promoname);
 $EmpIdname = $_SESSION['EMP'];
 $str_explodeEmpId=explode(",",$EmpIdname);

 // Later to be done
 $YesNoparam = $_GET['YesNoparam'];
 $SubCatparam = $_GET['SubCatparam'];
 $itemcodeparam = $_GET['itemcodeparam'];
  
 $miliStartDate = strtotime($startDate);
 $miliEndDate = strtotime($endDate);
 $miliStartDateSession = $miliStartDate;
 $miliEndDateSession = $miliEndDate;

 $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

 $mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
 $mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
 $datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

 $Empfilter['SalespersonId'] = $EmpIdname;
 $YesNoparamfilter['CustomerMobile'] = $YesNoparam;
 $SubCatparamfilter['SubCategory'] = $SubCatparam;
 $itemcodeparamfilter['Item_Code'] = $itemcodeparam;

 $mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
 $mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

 //////EMP/////
 $dateempfilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $dateempPostypefilterSession=array('SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 $datecatPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatSRPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecatSRfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 //$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
 //$Sitecatfilter = array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromoPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datessiteSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 

 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 //$Citycatfilter = array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

  $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromoPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecitySRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 //$statefilter = array('State'=>array('$in'=>$str_explodeState));
 //$statecatfilter = array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatecatPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromoPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datestateSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 //$zonefilter = array('Zone'=>array('$in'=>$str_explode));
 //$zonecatfilter = array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromoPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datezoneSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalespersonId'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


///////////POSTYPE LATER/////////
//$str_explodePOSSession=explode(",",$_SESSION['POSTypes']);
$dateposfilterSession = array('PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));



if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ //DONE
  //echo "<pre>"; print_r($_SESSION);die;

  
$result= executeBlock($datessitecatSRPostypefilterSession,'DateWiseSourceSiteWiseCatSRpostypeWiseContributionValue');
echo  $result;
}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //DONE
  //echo "<pre>"; print_r($_SESSION);die;

 
$result= executeBlock($datessitecatSRfilterSession,'DateWiseSourceSiteWiseCatSRWiseContributionValue');
echo  $result;


}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;
  $result= executeBlock($datessiteSRPostypefilterSession,'DateWiseSourceSiteWiseSRPostypeWiseContributionValue');
echo  $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessiteSRfilterSession,'DateWiseSRWiseContributionValue');
echo  $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitecatpromoPostypefilterSession,'DateWiseSourceSiteWiseCatPromopostypeWiseContributionValue');
echo  $result;


}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //DONE
  //echo "<pre>"; print_r($_SESSION);die;

  $result= executeBlock($datessitecatPostypefilterSession,'DateWiseSourceSiteWiseCatpostypeWiseContributionValue');
echo  $result;


}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

 
$result= executeBlock($datessitecatpromofilterSession,'DateWiseSourceSiteWiseCatPromoWiseContributionValue');
echo  $result;

}
else if ($Sitename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitepostypefilterSession,'DateWisePosTypeWiseSRWiseContributionValue');
echo  $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // ***************************************
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitecatfilterSession,'DateSourceSiteCategoryWiseSRWiseContributionValue');
echo  $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitefilterSession,'DateWiseSourceSiteWiseSRWiseContributionValue');
echo  $result;

}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

  
$result= executeBlock($datecitycatSRPostypefilterSession,'DateWiseCityCatSRPostypeWiseContributionValue');
echo  $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitycatSRfilterSession,'DateWiseCityCatSRWiseContributionValue');
echo  $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitySRPostypefilterSession,'DateWiseCitySRPostypeWiseContributionValue');
echo  $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // *******************************
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitySRfilterSession,'DateWiseSRWiseContributionValue');
echo  $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname && $POSTypeparam){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

   $result= executeBlock($datecitycatpromoPostypefilterSession,'DateWiseCityCatPromoPostypeWiseContributionValue');
echo  $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitycatpromofilterSession,'DateWiseCityCatPromoWiseContributionValue');
echo  $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ //DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitycatPostypefilterSession,'DateWiseCityCatPostypeWiseContributionValue');
echo  $result;

}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // ************************************
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitypostypefilterSession,'DateCityPosTypeWiseSRWiseContributionValue');
echo  $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //*********************************
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitycatfilterSession,'DateCityCategoryWiseSRWiseContributionValue');
echo  $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate']){ // ********************************************
  //echo "<pre>"; print_r($_SESSION);die;

 $result= executeBlock($datecityfilterSession,'DateWiseSRWiseContributionValue');
echo  $result;

}

else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ //DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestatecatSRPostypefilterSession,'DateWiseStateWiseCatSRPostypeWiseContributionValue');
echo  $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestatecatSRfilterSession,'DateWiseStateWiseCatSRWiseContributionValue');
echo  $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestateSRPostypefilterSession,'DateWiseStateWiseSRPostypeWiseContributionValue');
echo  $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // *************************************
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestateSRfilterSession,'DateStateEmpIdWiseSRWiseContributionValue');
echo  $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

  $result= executeBlock($datestatecatpromoPostypefilterSession,'DateWiseStateWiseCatPromoPostypeWiseContributionValue');
echo  $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestatecatpromofilterSession,'DateWiseStateWiseCatPromoWiseContributionValue');
echo  $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ //DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

  $result= executeBlock($datestatecatPostypefilterSession,'DateWiseStateWiseCatPostypeWiseContributionValue');
echo  $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // *******************************
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestatepostypefilterSession,'DateStatePosTypeWiseSRWiseContributionValue');
echo  $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // **************************
  //echo "<pre>"; print_r($str_explodeStateSession);die;

$result= executeBlock($datestatecatfilterSession,'DateStateCategoryWiseSRWiseContributionValue');
echo  $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate']){ // *****************************************
  //echo "<pre>"; print_r($statename);die;

$result= executeBlock($datestatefilterSession,'DateWiseStateWiseSRWiseContributionValue');
echo  $result;

}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatSRPostypefilterSession,'DateWiseZoneWiseCatSRPostypeWiseContributionValue');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatSRfilterSession,'DateWiseZoneWiseCatSRWiseContributionValue');
echo  $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

   $result= executeBlock($datezoneSRPostypefilterSession,'DateWiseZoneWiseSRPostypeWiseContributionValue');
echo  $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // **********************************
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

 $result= executeBlock($datezoneSRfilterSession,'DateWiseZoneWiseSRWiseContributionValue');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatpromoPostypefilterSession,'DateWiseZoneWiseCatPromoPostypeWiseContributionValue');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatpromofilterSession,'DateWiseZoneWiseCatPromoWiseContributionValue');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatPostypefilterSession,'DateWiseZoneWiseCatPostypeWiseContributionValue');
echo  $result;
}
else if ($zonename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // *********************************
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonepostypefilterSession,'DateZonePosTypeWiseSRWiseContributionValue');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // **********************************
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatfilterSession,'DateZoneCategoryWiseSRWiseContributionValue');
echo  $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){ // *********************************
        //echo $_SESSION['endDate'];
  //echo "<pre>"; print_r($datezonefilterSession);die;

$result= executeBlock($datezonefilterSession,'DateWiseZoneWiseSRWiseContributionValue');
echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname && $POSTypeparam){ // ***********
  //echo "<pre>"; print_r($_SESSION);die;

  
$result= executeBlock($datecatSRpromoPostypefilterSession,'DateEmpCatPromoPostypeWiseSRWiseContributionValue');
echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datecatSRpromofilterSession,'DateWiseSRWiseCatPromoWiseContributionValue');
echo  $result;
}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //********************
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datecatSRPostypefilterSession,'DateEmpCatPostypeWiseSRWiseContributionValue');
echo  $result;
}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datecatSRfilterSession,'DateWiseCategoryWiseSRWiseContributionValue');
echo  $result;


}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // *******************
  //echo "<pre>"; print_r($_SESSION);die;

 $result= executeBlock($datecatpromoPostypefilterSession,'DateWiseCategoryPromoPostypeWiseSRWiseContributionValue');
echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //******************************
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datecatPostypefilterSession,'DateCategoryPosTypeWiseSRWiseContributionValue');
echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // *****************************
  //echo "<pre>"; print_r($_SESSION);die;

 $result= executeBlock($datecatpromofilterSession,'DatePromoCategoryWiseSRWiseContributionValue');
  echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // ***************************
  //echo "<pre>"; print_r($_SESSION);die;

  $result= executeBlock($datecatfilterSession,'DateWiseCategoryWiseSRWiseContributionValue');
  echo  $result;

}
else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //*****************************
  //echo "<pre>"; print_r($EmpIDfilter['SalespersonId']);die;

   $result= executeBlock($dateempPostypefilterSession,'DateEmpPostypeWiseSRWiseContributionValue');
   echo  $result;

}

else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // ****************************************
  //echo "<pre>"; print_r($_SESSION);die;

 $result= executeBlock($dateposfilterSession,'DateWisePosTypeWiseSRWiseContributionValue');
  echo  $result;

}

else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($EmpIDfilter['SalespersonId']);die;

   $result= executeBlock($dateempfilterSession,'DateWiseSRWiseContributionValue');
   echo  $result;

}


///////////////////////////////////////////// end end  end  end  end  end /////////////////////////////////////

else if($startDate && $endDate){

  $result= executeBlock($datefilter,'DateWiseSRWiseContributionValue');
   echo  $result;
}


else if($YesNoparamfilter['CustomerMobile'])
{
  
   $result= executeBlock($YesNoparamfilter,'CustomerDetailsWiseSRWiseContributionValue');
   echo  $result;

}

else if($SubCatparamfilter['SubCategory'])
{

  $result= executeBlock($SubCatparamfilter,'SubCategoryWiseSRWiseContributionValue');
  echo  $result;

}
else if($itemcodeparamfilter['Item_Code'])
{
  
  $result= executeBlock($itemcodeparamfilter,'TopTensellingWiseSalespersonWiseContributionValue');
  echo  $result;


}
else
  {
  
          $result= executeBlock($datefilter,'DateWiseSRWiseContributionValue');
          echo  $result;

    }


    function executeBlock($queryVar,$collection){
//  $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");
//   $col = "SaleRepInsight.".$collection;
//   $query = new MongoDB\Driver\Query($queryVar); 

// $rows  = $connection->executeQuery($col, $query);
      $rows = getData($queryVar,$collection);

 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SalespersonId"]==trim($row->SalespersonId)){
		
	 	 $findCounter    = 1;
	        $oldV           = $data[$i]["percentage"];
		$data[$i]["percentage"]    = $oldV+($row->Amount);                  
               break;
           }
          }

            if($findCounter==0){
              
              $data[$i]     =  array("SalespersonId"=>trim($row->SalespersonId),"Group"=>trim($row->Salesperson),"percentage"=>trim($row->Amount),"PoSName"=>trim($row->City),"SourceSite"=>trim($row->SourceSite));
            } 
            else {
              $findCounter  = 0;
            }
          }
          return json_encode($data);
}


?>
