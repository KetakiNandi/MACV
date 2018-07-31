<?php
require_once(__DIR__.'/config.php');
 session_start();
 $param = $_GET['param'];
 if($param=="YES"){
  unset($_SESSION["stDate1"]);
  unset($_SESSION["endDate1"]);
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


$_SESSION['stDate1'] =  "01-Jan-17";
  
$_SESSION['endDate1']= "31-Mar-17";

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
 $startDate = $_SESSION['stDate1'];//01-Jan-17
 $endDate = $_SESSION['endDate1'];//31-Jan-17
 $categoryname = $_SESSION['Categories'];
 $str_explodeCatgory=explode(",",$categoryname);
 $Promoname = $_SESSION['ProNames'];
 $str_explodePromo=explode(",",$Promoname);
 $EmpIdname = $_SESSION['EMP'];
 $str_explodeEmpId=explode(",",$EmpIdname);

 // Later to be done
 //$YesNoparam = $_GET['YesNoparam'];
 //$SubCatparam = $_GET['SubCatparam'];
 //$itemcodeparam = $_GET['itemcodeparam'];
  
 $miliStartDate = strtotime($startDate);
 $miliEndDate = strtotime($endDate);
 $miliStartDateSession = $miliStartDate;
 $miliEndDateSession = $miliEndDate;

 $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

 $mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
 $mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
 $datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

 $Empfilter['SalesRepNameid'] = $EmpIdname;
 //$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
 //$SubCatparamfilter['SubCategory'] = $SubCatparam;
 //$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

 $mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
 $mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

 //////EMP/////
 $dateempfilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $dateempPostypefilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 $datecatPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatSRPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecatSRfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 //$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
 //$Sitecatfilter = array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromoPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datessiteSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 

 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 //$Citycatfilter = array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

  $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromoPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecitySRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 //$statefilter = array('State'=>array('$in'=>$str_explodeState));
 //$statecatfilter = array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatecatPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromoPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datestateSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 //$zonefilter = array('Zone'=>array('$in'=>$str_explode));
 //$zonecatfilter = array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromoPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datezoneSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


///////////POSTYPE LATER/////////
//$str_explodePOSSession=explode(",",$_SESSION['POSTypes']);
$datePOSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));



if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ //
  $result = executeBlock( $datessitecatSRPostypefilterSession , 'DateSourceSiteWiseCategoryWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //
  $result = executeBlock( $datessitecatSRfilterSession , 'DateSourceSiteWiseCategoryWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //
  $result = executeBlock( $datessiteSRPostypefilterSession , 'DateWiseSourceSiteWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //
  $result = executeBlock( $datessiteSRfilterSession , 'DateWiseSourceSiteWiseSRWiseWeekDaySalesMonth');
  echo $result; 

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ //
  $result = executeBlock( $datessitecatpromoPostypefilterSession , 'DateWiseSourceSiteWiseCategoryWisePosTypeWisePromoWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //
  $result = executeBlock( $datessitecatPostypefilterSession , 'DateWiseSourceSiteWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ //
  $result = executeBlock( $datessitecatpromofilterSession , 'DateSourceSiteCategoryPromoWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ //
  $result = executeBlock( $datessitepostypefilterSession , 'DateWiseSourceSiteWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //
  $result = executeBlock( $datessitecatfilterSession , 'DateWiseSourceSiteWiseCategoryWiseWeekDaySalesMonth');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){ //
  $result = executeBlock( $datessitefilterSession , 'DateWiseSourceSiteWiseWeekDaySalesMonth');
  echo $result;

}

//end sourceSite
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //
  $result = executeBlock( $datecitycatSRPostypefilterSession , 'DateCityWiseCategoryWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //done
  $result = executeBlock( $datecitySRPostypefilterSession , 'DateWiseCityWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}

else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //
  $result = executeBlock( $datecitycatSRfilterSession , 'DateWiseCityWiseCategoryWiseSRWiseWeekDaySalesMonth');
  echo $result;
}

else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //done
  $result = executeBlock( $datecitySRfilterSession , 'DateWiseCityWiseSRWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname && $POSTypeparam){ //
  $result = executeBlock( $datecitycatpromoPostypefilterSession , 'DateWiseCityWiseCategoryWisePosTypeWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ //done
  $result = executeBlock( $datecitycatpromofilterSession , 'DateWiseCityWiseCategoryWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ //
  $result = executeBlock( $datecitycatPostypefilterSession , 'DateWiseCityWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ //
  $result = executeBlock( $datecitypostypefilterSession , 'DateWiseCityWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datecitycatfilterSession , 'DateWiseCityWiseCategoryWiseWeekDaySalesMonth');
  echo $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datecityfilterSession , 'DateWiseCityWiseWeekDaySalesMonth');
  echo $result;

}
//end City
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ //done
  $result = executeBlock( $datestatecatSRPostypefilterSession , 'DateStateWiseCategoryWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //done
  $result = executeBlock( $datestatecatSRfilterSession , 'DateWiseStateWiseCategoryWiseSRWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //Done
  $result = executeBlock( $datestateSRPostypefilterSession , 'DateWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //done
  $result = executeBlock( $datestateSRfilterSession , 'DateWiseStateWiseSRWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname){ //done
  $result = executeBlock( $datestatecatpromoPostypefilterSession , 'DateWiseStateWiseCategoryWisePosTypeWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ //done
  $result = executeBlock( $datestatecatpromofilterSession , 'DateWiseStateWiseCategoryWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ //done
  $result = executeBlock( $datestatecatPostypefilterSession , 'DateWiseStateWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ //Done
  $result = executeBlock( $datestatepostypefilterSession , 'DateWiseStateWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datestatecatfilterSession , 'DateWiseStateWiseCategoryWiseWeekDaySalesMonth');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datestatefilterSession , 'DateWiseStateWiseWeekDaySalesMonth');
  echo $result;

}
//=================end State

else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ //done
  $result = executeBlock( $datezonecatSRPostypefilterSession , 'DateZoneWiseCategoryWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //done
  $result = executeBlock( $datezonecatSRfilterSession , 'DateWiseSRWiseCategoryWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //done
  $result = executeBlock( $datezoneSRPostypefilterSession , 'DateWiseZoneWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //done
  $result = executeBlock( $datezoneSRfilterSession , 'DateWiseZoneWiseSRWiseWeekDaySalesMonth');
  echo $result;
  
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ //Done
  $result = executeBlock( $datezonecatpromoPostypefilterSession , 'DateWiseZoneWiseCategoryWisePosTypeWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){//done
  $result = executeBlock( $datezonecatpromofilterSession , 'DateWiseZoneWiseCategoryWisePromoWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //done
  $result = executeBlock( $datezonecatPostypefilterSession , 'DateWiseZoneWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datezonepostypefilterSession , 'DateWiseZoneWisePosTypeWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //done
  $result = executeBlock( $datezonecatfilterSession , 'DateWiseZoneWiseCategoryWiseWeekDaySalesMonth');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){ //Done



  $result = executeBlock( $datezonefilterSession , 'DateWiseZoneWiseWeekDaySalesMonth');
  echo $result;

}
//================================Zone end ======================================
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname && $POSTypeparam){ //
  $result = executeBlock( $datecatSRpromoPostypefilterSession , 'DateWiseSRWiseCategoryWisePosTypeWisePromoWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname){ //
  $result = executeBlock( $datecatSRpromofilterSession , 'DateWiseSRWiseCategoryWisePromoWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ //
  $result = executeBlock( $datecatSRPostypefilterSession , 'DateWiseSRWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ //
  $result = executeBlock( $datecatSRfilterSession , 'DateWiseSRWiseCategoryWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ //
  $result = executeBlock( $datecatpromoPostypefilterSession , 'DateWiseCategoryWisePromoWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //
  $result = executeBlock( $datecatPostypefilterSession , 'DateWiseCategoryWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ //
  $result = executeBlock( $datecatpromofilterSession , 'DateWiseCategoryWisePromoWeekDaySalesMonth');
  echo $result;

}

else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // *************************************
  $result = executeBlock( $datecatfilterSession , 'DateWiseCategoryWiseWeekDaySalesMonth');
  echo $result;

}
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // **************************************************
  $result = executeBlock( $datePOSTypefilter , 'DateWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //
  $result = executeBlock( $dateempPostypefilterSession , 'DateWiseSRWisePosTypeWiseWeekDaySalesMonth');
  echo $result;

}
else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate']){ //
  $result = executeBlock( $dateempfilterSession , 'DateWiseSRWiseWeekDaySalesMonth');
  echo $result;

}

   ///////////////////////////////////// end end end //////////////////////////////////////////   

else if($startDate && $endDate){
  $result = executeBlock( $datefilter , 'WeekDaySalesMonth');
  echo $result; 
  }
/*
else if($YesNoparamfilter['CustomerMobile'])
      {
        $result = executeBlock( $YesNoparamfilter , 'CustomerDetailsWiseSalesPerformanceQtn');
        echo $result;
    }
    else if($SubCatparamfilter['SubCategory'])
      {
        $result = executeBlock( $SubCatparamfilter , 'SubCategoryWiseSalesPerformanceQtn');
        echo $result;
    }
    
    else if($itemcodeparamfilter['Item_Code'])
      {
        $result = executeBlock( $itemcodeparamfilter , 'TopTensellingWiseSalesperformanceQtn');
        echo $result;
    }*/
else
{
  $result = executeBlock($datefilter , 'WeekDaySalesMonth');

  //  echo "<pre>"; print_r("sssssssssssssss");die;
  echo $result;

}
  
  
function executeBlock($queryVar,$collection){
 // $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");
 //  $col                  = "SaleRepInsight.".$collection;
 //  $query                = new MongoDB\Driver\Query($queryVar); 
 //  $rows                 = $connection->executeQuery($col, $query);
  $rows                 = getData($queryVar,$collection);
  $data                 = array();
  $findCounter          = 0;
 foreach ($rows as $row){
  for($i=0;$i<count($data);$i++){
    if($data[$i]["Month"]==$row->Month){  
     $findCounter    = 1;
      $oldV           = $data[$i]["Quantity"];
      $data[$i]["Quantity"]    = $oldV+$row->Quantity;     
      break;      
     }
  }
  if($findCounter==0){
    $data[$i]     =  array("Month"=>($row->Month),"Quantity"=>($row->Quantity));
  } else {
    $findCounter  = 0;
  }
}
array_walk_recursive($data, function (&$b) { $b = (string)$b; });
echo json_encode($data);

}

?>
