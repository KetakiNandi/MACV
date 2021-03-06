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
  $EmpIdname = $_SESSION['EMP'];
  $Sitename = $_SESSION['Sites'];
  $str_explodeSite=explode(",",$Sitename);
  $categoryname = $_SESSION['Categories'];
  $str_explodeCatgory=explode(",",$categoryname);
  $Promoname = $_SESSION['ProNames'];
  $str_explodePromo=explode(",",$Promoname);
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
 $dateempfilterSession=array('SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatSRfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>$EmpIdname,'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;


if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatSRpromofilterSession); 

    //     $rows  = $connection->executeQuery("SaleRepInsight.datecatemppromopostype", $query); //category collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datecatSRpromofilterSession,'datecatemppromopostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datecatSRfilterSession); 

    //     $rows  = $connection->executeQuery("SaleRepInsight.datecatemppostype", $query); //category collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
      $data = executeBlock($datecatSRfilterSession,'datecatemppostype');
	    $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datessiteSRfilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datesourcesiteempidpostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datessiteSRfilterSession,'datesourcesiteempidpostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datessitecatpromofilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.datesourcesitecatpromopostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datessitecatpromofilterSession,'datesourcesitecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datessitecatfilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateSourceSitePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datessitecatfilterSession,'DateSourceSitePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datessitefilterSession); 

    //       $rows  = $connection->executeQuery("SaleRepInsight.DateSourceSitePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datessitefilterSession,'DateSourceSitePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datecitySRfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datecityempidpostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
          $data = executeBlock($datecitySRfilterSession,'datecityempidpostype');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecitycatpromofilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datecitycatpromopostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datecitycatpromofilterSession,'datecitycatpromopostype');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecitycatfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateCityPosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
          $data = executeBlock($datecitycatfilterSession,'DateCityPosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecityfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateCityPosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
          $data = executeBlock($datecityfilterSession,'DateCityPosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datestateSRfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datestateempidpostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datestateSRfilterSession,'datestateempidpostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datestatecatpromofilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datestatecatpromopostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datestatecatpromofilterSession,'datestatecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datestatecatfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateStatePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datestatecatfilterSession,'DateStatePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datestatefilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateStatePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datestatefilterSession,'DateStatePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
    // $query = new MongoDB\Driver\Query($datezoneSRfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datezoneempidpostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
     $data = executeBlock($datezoneSRfilterSession,'datezoneempidpostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datezonecatpromofilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.datezonecatpromopostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datezonecatpromofilterSession,'datezonecatpromopostype');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datezonecatfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateZonePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datezonecatfilterSession,'DateZonePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datezonefilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.DateZonePosTypeWiseCategorywisePerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datezonefilterSession,'DateZonePosTypeWiseCategorywisePerformanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($dateempfilterSession); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.dateemppostype", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($dateempfilterSession,'dateemppostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
    // $query = new MongoDB\Driver\Query($datecatpromofilterSession); 

    //     $rows  = $connection->executeQuery("SaleRepInsight.datecatpromopostype", $query); //category collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datecatpromofilterSession,'datecatpromopostype');
	   $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    // $query = new MongoDB\Driver\Query($datecatfilterSession); 

    //     $rows  = $connection->executeQuery("SaleRepInsight.DatePOSTypeCategoryWiseSubCategorywisePerormanceQtn", $query); //category collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
          //echo json_encode($data);
    $data = executeBlock($datecatfilterSession,'DatePOSTypeCategoryWiseSubCategorywisePerormanceQtn');
	  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
  }
else if($startDate && $endDate)
  {
    // $query = new MongoDB\Driver\Query($datefilter); 

    //     $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseSalesPerformanceQtn", $query); //PromoName collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($datefilter,'PosTypeWiseSalesPerformanceQtn');
        echo json_encode($data);
  }
else if($SubCatparamfilter['SubCategory'])
  {
    // $query = new MongoDB\Driver\Query($SubCatparamfilter); 

    //      // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

    //     $rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWiseSubCategorywisePerormanceQtn", $query); //PromoName collections

    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
    $data = executeBlock($SubCatparamfilter,'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName');
        echo json_encode($data);
  }
  else if($itemcodeparamfilter['Item_Code'])
  {
    //$query = new MongoDB\Driver\Query($itemcodeparamfilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        // $rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWiseTopTenSellingItemsQtn", $query); //PromoName collections

        //   $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["CIty"]==trim($row->City)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("CIty"=>trim($row->City),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
        //   echo json_encode($data);
         $data = executeBlock($itemcodeparamfilter,'DateWisePosTypeWiseTopTenSellingItemsQtn');
        echo json_encode($data);
  }
else
    {
    // $query = new MongoDB\Driver\Query($datefilter); 
    //       $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseSalesPerformanceQtn", $query);
    //       $result = array();
    //       foreach($rows as $row){
    //           for($i=0;$i<count($data);$i++){
    //           if($data[$i]["PosType"]==trim($row->PosType)){          
    //             $findCounter    = 1;
    //             $oldV           = $data[$i]["count"];
    //             $data[$i]["count"]    = $oldV+1;          
    //             break;
    //           }
    //         }
    //         if($findCounter==0){
    //           $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
    //         } 
    //         else {
    //           $findCounter  = 0;
    //         }
    //       }
    //       echo json_encode($data);
      $data = executeBlock($datefilter,'PosTypeWiseSalesPerformanceQtn');
      echo json_encode($data);

    }

    function executeBlock($queryVar,$collection){
      $rows = getData($queryVar,$collection);
      $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosType"]==trim($row->PosType)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //return $data;
	$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

	return($dataWithDateParam);
    }
?>
