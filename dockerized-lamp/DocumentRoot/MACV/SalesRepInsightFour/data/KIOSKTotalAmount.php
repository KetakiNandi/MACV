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
  session_destroy();
}

if(!empty($_GET['startDate'])){
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
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
  $_SESSION['zones'] =  $_GET['zoneparam'];
}

if(!empty($_GET['Stateparam'])){
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
    $_SESSION['states'] =  $_GET['Stateparam'];
}

if(!empty($_GET['Cityparam'])){
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  $_SESSION['cities'] =  $_GET['Cityparam'];
}

if(!empty($_GET['POSTypeparam'])){
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  $_SESSION['POSTypes'] =  $_GET['POSTypeparam'];
}

if(!empty($_GET['Siteparam'])){
  unset($_SESSION['Categories']);
  $_SESSION['Sites'] =  $_GET['Siteparam'];
}

if(!empty($_GET['categoryparam'])){
  $_SESSION['Categories'] =  $_GET['categoryparam'];
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
  
 $miliStartDate = strtotime($startDate);
 $miliEndDate = strtotime($endDate);
 $miliStartDateSession = $miliStartDate;
 $miliEndDateSession = $miliEndDate;

 $connection = new MongoDB\Driver\Manager("mongodb://mongo:27017");

 $mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
 $mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
 $datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

 $mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
 $mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);


 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatPostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PosType'=>array('$in'=>$str_explodePOSSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 //$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
 //$Sitecatfilter = array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatPostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 //$Citycatfilter = array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

  $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatPostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 //$statefilter = array('State'=>array('$in'=>$str_explodeState));
 //$statecatfilter = array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatecatPostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 //$zonefilter = array('Zone'=>array('$in'=>$str_explode));
 //$zonecatfilter = array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory));
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatPostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

///////////POSTYPE LATER/////////
//$str_explodePOSSession=explode(",",$_SESSION['POSTypes']);
$dateposfilterSession = array('PosType'=>array('$in'=>$str_explodePOSSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ //DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitecatPostypefilterSession,'DateSourceSiteWiseCatWisePOSTypeWiseKIOSKAvgSale');
echo  $result;

}
else if ($Sitename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitepostypefilterSession,'DateWiseSourceSiteWisePOSTypeWiseKIOSKAvgSale');
echo  $result;

}
else if ($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;


$result= executeBlock($datessitecatfilterSession,'DateWiseSourceSiteWiseCategoryWiseKIOSKAvgSale');
echo  $result;
}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  // echo "sagarrrrrrrrrrrr";
  // echo "<pre>"; print_r($_SESSION);die;

$result= executeBlock($datessitefilterSession,'DateWiseSourceSiteWiseKIOSKAvgSale');
echo  $result;

}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;
    
$result= executeBlock($datecitycatPostypefilterSession,'DateCityWiseCatWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($Cityname && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitypostypefilterSession,'DateWiseCityWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION['stDate']);die;

$result= executeBlock($datecitycatfilterSession,'DateWiseCityWiseCategoryWiseKIOSKAvgSale');
echo  $result;
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die; 
$result= executeBlock($datecityfilterSession,'DateWiseCityWiseKIOSKAvgSale');
echo  $result;

}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;
 
$result= executeBlock($datestatecatPostypefilterSession,'DateStateWiseCatWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($statename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($str_explodeStateSession);die;

 
$result= executeBlock($datestatepostypefilterSession,'DateWiseStateWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ //DONE 
  //echo "<pre>"; print_r($str_explodeStateSession);die;

 
$result= executeBlock($datestatecatfilterSession,'DateWiseStateWiseCategoryWiseKIOSKAvgSale');
echo  $result;
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($statename);die;

$result= executeBlock($datestatefilterSession,'DateWiseStateWiseKIOSKAvgSale');
echo  $result;

}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonecatPostypefilterSession,'DateZoneWiseCatWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($zonename && $POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die;

$result= executeBlock($datezonepostypefilterSession,'DateWiseZoneWisePOSTypeWiseKIOSKAvgSale');
echo  $result;
}
else if ($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
                        //echo "1111";
      //echo "<pre>"; print_r($datezonecatfilterSession);die; 
$result= executeBlock($datezonecatfilterSession,'DateWiseZoneWiseCategoryWiseKIOSKAvgSale');
echo  $result;
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){ //DONE
        //echo $_SESSION['endDate'];
  //echo "<pre>"; print_r($datezonefilterSession);die;

 
$result= executeBlock($datezonefilterSession,'DateWiseZoneWiseKIOSKAvgSale');
echo  $result;

}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;
 
$result= executeBlock($datecatPostypefilterSession,'DateWiseCategoryWisePOSTypeWiseKIOSKAvgSale');
echo  $result;


}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){ // DONE
  //echo "<pre>"; print_r($_SESSION);die;
  $result= executeBlock($datecatfilterSession,'DateWiseCategoryWiseKIOSKAvgSale');
  echo  $result;

}
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){   // *****************************************
  //echo "<pre>"; print_r($_SESSION);die;

  
    $result= executeBlock($dateposfilterSession,'DateWisePOSTypeWiseKIOSKAvgSale');
    echo  $result;

}

else
  {
//	echo "<pre>"; print_r($datefilter,);die;
          $result= executeBlock($datefilter,'DateWiseKIOSKAvgSale');
          echo  $result;

}

function executeBlock($queryVar,$collection){
//  $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");
//   $col = "SaleRepInsight.".$collection;
//   $query = new MongoDB\Driver\Query($queryVar); 

// $rows  = $connection->executeQuery($col, $query);
  $rows = getData($queryVar,$collection);
  $data = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["Amount"];
                $data[$i]["Amount"]    = $oldV+$row->Amount;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"Amount"=>trim($row->Amount));
            } 
            else {
              $findCounter  = 0;
            }
          }
	//$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        //$dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

return json_encode($data);
}

  


?>
