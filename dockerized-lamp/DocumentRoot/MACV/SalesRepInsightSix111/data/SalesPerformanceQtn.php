<?php
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

 $Empfilter['SalesRepNameid'] = $EmpIdname;
 $YesNoparamfilter['CustomerMobile'] = $YesNoparam;
 $SubCatparamfilter['SubCategory'] = $SubCatparam;
 $itemcodeparamfilter['Item_Code'] = $itemcodeparam;

 $mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
 $mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

 //////EMP/////
 $dateempfilterSession=array('SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $dateempPostypefilterSession=array('SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 $datecatPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecatSRPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromoPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecatSRfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 //$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
 //$Sitecatfilter = array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromoPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datessiteSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatSRPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 

 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessitecatSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 //$Citycatfilter = array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

  $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromoPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datecitySRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatSRPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitycatSRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 //$statefilter = array('State'=>array('$in'=>$str_explodeState));
 //$statecatfilter = array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatecatPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromoPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datestateSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatSRPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestatecatSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 //$zonefilter = array('Zone'=>array('$in'=>$str_explode));
 //$zonecatfilter = array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromoPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo),'PosType'=>array('$in'=>$str_explodePOSSession));
 $datezoneSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatSRPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezonecatSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


///////////POSTYPE LATER/////////
//$str_explodePOSSession=explode(",",$_SESSION['POSTypes']);
$datePOSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));



if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ // DONE
  $result = executeBlock( $datessitecatSRPostypefilterSession , 'DateSourceSiteCategorySRPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datessitecatSRfilterSession , 'DateSourceSiteCategorySRWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datessiteSRPostypefilterSession , 'DateSourceSiteSRPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datessiteSRfilterSession , 'DateSourceSiteEmpIdWiseSalesPerformanceQtn');
  echo $result; 

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // DONE
  $result = executeBlock( $datessitecatpromoPostypefilterSession , 'DateSourceSiteCategoryPromoPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
  $result = executeBlock( $datessitecatPostypefilterSession , 'DateSourceSiteCategoryPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  $result = executeBlock( $datessitecatpromofilterSession , 'DateSourceSiteCategoryPromoWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datessitepostypefilterSession , 'DateSourceSitePosTypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datessitecatfilterSession , 'DateSourceSiteCategoryWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datessitefilterSession , 'DateWiseSourceSiteWiseSalesPerformanceQtn');
  echo $result;

}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datecitycatSRPostypefilterSession , 'DateCityCategorySRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datecitycatSRfilterSession , 'DateCityCategorySRWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datecitySRPostypefilterSession , 'DateCitySRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datecitySRfilterSession , 'DateCityEmpIdWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname && $POSTypeparam){ // DONE
  $result = executeBlock( $datecitycatpromoPostypefilterSession , 'DateCityCategoryPromoPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  $result = executeBlock( $datecitycatpromofilterSession , 'DateCityCategoryPromoWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ // DONE
  $result = executeBlock( $datecitycatPostypefilterSession , 'DateCityCategoryPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datecitypostypefilterSession , 'DateCityPosTypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datecitycatfilterSession , 'DateCityCategoryWiseSalesPerformanceQtn');
  echo $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datecityfilterSession , 'DateWiseCityWiseSalesPerformanceQtn');
  echo $result;

}

else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ // DONE
  $result = executeBlock( $datestatecatSRPostypefilterSession , 'DateStateCategorySRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datestatecatSRfilterSession , 'DateStateCategorySRWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datestateSRPostypefilterSession , 'DateStateSRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datestateSRfilterSession , 'DateStateEmpIdWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname){ // DONE
  $result = executeBlock( $datestatecatpromoPostypefilterSession , 'DateStateCategoryPromoPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  $result = executeBlock( $datestatecatpromofilterSession , 'DateStateCategoryPromoWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ // DONE
  $result = executeBlock( $datestatecatPostypefilterSession , 'DateStateCategoryPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datestatepostypefilterSession , 'DateStatePosTypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datestatecatfilterSession , 'DateStateCategoryWiseSalesPerformanceQtn');
  echo $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datestatefilterSession , 'DateWiseStateWiseSalesPerformanceQtn');
  echo $result;

}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam && $categoryname){ // DONE
  $result = executeBlock( $datezonecatSRPostypefilterSession , 'DateZoneCategorySRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datezonecatSRfilterSession , 'DateZoneCategorySRWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datezoneSRPostypefilterSession , 'DateZoneSRPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datezoneSRfilterSession , 'DateZoneEmpIdWiseSalesPerformanceQtn');
  echo $result;
  
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // DONE
  $result = executeBlock( $datezonecatpromoPostypefilterSession , 'DateZoneCategoryPromoPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){
  $result = executeBlock( $datezonecatpromofilterSession , 'DateZoneCategoryPromoWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
  $result = executeBlock( $datezonecatPostypefilterSession , 'DateZoneCategoryPostypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datezonepostypefilterSession , 'DateZonePosTypeWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $datezonecatfilterSession , 'DateZoneCategoryWiseSalesPerformanceQtn');
  echo $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);
 // echo "<pre>"; print_r($_SESSION['endDate']);
 // die;
  $result = executeBlock( $datezonefilterSession , 'DateWiseZoneWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname && $POSTypeparam){ // DONE
  $result = executeBlock( $datecatSRpromoPostypefilterSession , 'DateEmpIdCatPromoPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname){ // DONE
  $result = executeBlock( $datecatSRpromofilterSession , 'DateEmpIdCategoryPromoWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $POSTypeparam){ // DONE
  $result = executeBlock( $datecatSRPostypefilterSession , 'DateEmpIdCatPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname){ // DONE
  $result = executeBlock( $datecatSRfilterSession , 'DateEmpIdCategoryWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam && $Promoname){ // DONE
  $result = executeBlock( $datecatpromoPostypefilterSession , 'DatePOSTypeCategoryPromoWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
  $result = executeBlock( $datecatPostypefilterSession , 'DatePOSTypeCategoryWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname){ // DONE
  $result = executeBlock( $datecatpromofilterSession , 'DatePromoCategoryWiseSalesPerformanceQtn');
  echo $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // *************************************
  $result = executeBlock( $datecatfilterSession , 'CategoryWiseSalesPerformanceQtn');
  echo $result;

}
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // **************************************************
  $result = executeBlock( $datePOSTypefilter , 'PosTypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
  $result = executeBlock( $dateempPostypefilterSession , 'DateEmpIdPostypeWiseSalesPerformanceQtn');
  echo $result;

}
else if ($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  $result = executeBlock( $dateempfilterSession , 'SalesRepWiseSalesPerformanceQtn');
  echo $result;

}

   ///////////////////////////////////// end end end //////////////////////////////////////////   

else if($startDate && $endDate){
  $result = executeBlock( $datefilter , 'SalesPerformanceQtn');
  echo $result; 
  }
else
{
  //echo "<pre>"; print_r($_SESSION['stDate']);
 // echo "<pre>"; print_r($_SESSION['endDate']);
 // die;
  $result = executeBlock($datefilter , 'SalesPerformanceQtn');
  echo $result;

}
  
  
  function executeBlock($queryVar,$collection){
 $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");
  $col                  = "SaleRepInsight.".$collection;
  $query                = new MongoDB\Driver\Query($queryVar); 
  $rows                 = $connection->executeQuery($col, $query);
  $data                 = array();
  $findCounter          = 0;
  foreach ($rows as $row){
   $milliseconds = $row->date->toDateTime();
  for($i=0;$i<count($data);$i++){
    if($data[$i]["Month"]==$milliseconds->format('M')){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Count"];
      $data[$i]["Count"]    = $oldV+$row->Count;     
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("Month"=>($milliseconds->format('M')),"Count"=>($row->Count));
  } else {
    $findCounter  = 0;
  }
 }
  return  json_encode($data);
}

  
?>

