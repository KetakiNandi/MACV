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
$Promoname = $_SESSION['ProNames'];
$str_explodePromo=explode(",",$Promoname);
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17
$EmpIdname = $_SESSION['EMP'];

////LATER/////
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

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);


 /////////EMP///////////
 //$Empfilter['SalesRepNameid'] = $EmpIdname;
 $dateempfilterSession=array('SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $dateemppostypefilterSession=array('SalesRepNameid'=>$EmpIdname,'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCity),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeState),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explode),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
        // $query = new MongoDB\Driver\Query($dateemppostypefilterSession);
         
        // $rows  = $connection->executeQuery("SaleRepInsight.datecatemppostype", $query); //collection RepNmae,Id,category,promoname
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
          //echo json_encode($data);
          $data = executeBlock($dateemppostypefilterSession , 'datecatemppostype');  
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
 else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
        // $query = new MongoDB\Driver\Query($dateempfilterSession);
         
        // $rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWiseCategorywisePerformanceQtn", $query); //collection RepNmae,Id,category,promoname
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
          //echo json_encode($data);
          $data = executeBlock($dateempfilterSession , 'DateWiseEmpIdWiseCategorywisePerformanceQtn');  
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
     {
   
       // $query = new MongoDB\Driver\Query($datessitepostypefilterSession); 
       // $rows  = $connection->executeQuery("SaleRepInsight.DateSourceSitePosTypeWiseCategorywisePerformanceQtn", $query);
       // $result = array();
       //    foreach($rows as $row){
       //        for($i=0;$i<count($data);$i++){
       //        if($data[$i]["Division"]==trim($row->Category)){          
       //          $findCounter    = 1;
       //          $oldV           = $data[$i]["count"];
       //          $data[$i]["count"]    = $oldV+1;          
       //          break;
       //        }
       //      }
       //      if($findCounter==0){
       //        $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
       //      } 
       //      else {
       //        $findCounter  = 0;
       //      }
       //    }
          //echo json_encode($data);
      $data = executeBlock($datessitepostypefilterSession , 'DateSourceSitePosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
     {
   
       // $query = new MongoDB\Driver\Query($datessitefilterSession); 
       // $rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWiseCategorywisePerformanceQtn", $query);
       // $result = array();
       //    foreach($rows as $row){
       //        for($i=0;$i<count($data);$i++){
       //        if($data[$i]["Division"]==trim($row->Category)){          
       //          $findCounter    = 1;
       //          $oldV           = $data[$i]["count"];
       //          $data[$i]["count"]    = $oldV+1;          
       //          break;
       //        }
       //      }
       //      if($findCounter==0){
       //        $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
       //      } 
       //      else {
       //        $findCounter  = 0;
       //      }
       //    }
          //echo json_encode($data);
      $data = executeBlock($datessitefilterSession , 'DateWiseSourceSiteWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
        
        // $query = new MongoDB\Driver\Query($datecitypostypefilterSession); 
        // $rows  = $connection->executeQuery("SaleRepInsight.DateCityPosTypeWiseCategorywisePerformanceQtn", $query);
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
          //echo json_encode($data);
        $data = executeBlock($datecitypostypefilterSession , 'DateCityPosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

      }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
        
        // $query = new MongoDB\Driver\Query($datecityfilterSession); 
        // $rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWiseCategorywisePerformanceQtn", $query);
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
          //echo json_encode($data);
        $data = executeBlock($datecityfilterSession , 'DateWiseCityWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

      }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
        {

          // $query = new MongoDB\Driver\Query($datestatepostypefilterSession); 
          // $rows  = $connection->executeQuery("SaleRepInsight.DateStatePosTypeWiseCategorywisePerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
          $data = executeBlock($datestatepostypefilterSession , 'DateStatePosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
        {

          // $query = new MongoDB\Driver\Query($datestatefilterSession); 
          // $rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseCategorywisePerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
          $data = executeBlock($datestatefilterSession , 'DateWiseStateWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
        {
          // $query = new MongoDB\Driver\Query($datezonepostypefilterSession); 
          // $rows  = $connection->executeQuery("SaleRepInsight.DateZonePosTypeWiseCategorywisePerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
          $data = executeBlock($datezonepostypefilterSession , 'DateZonePosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
 else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
        {
          // $query = new MongoDB\Driver\Query($datezonefilterSession); 
          // $rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseCategorywisePerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
          $data = executeBlock($datezonefilterSession , 'DateWiseZoneWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
        {
          // $query = new MongoDB\Driver\Query($datepostypefilterSession); 
          // $rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWiseCategorywisePerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          //echo json_encode($data);
          $data = executeBlock($datepostypefilterSession , 'DateWisePosTypeWiseCategorywisePerformanceQtn');
          $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

        }
else if($startDate && $endDate)
        {
          // $query = new MongoDB\Driver\Query($datefilter); 
          // $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSalesPerformanceQtn", $query);
          // $result = array();
          // foreach($rows as $row){
          //     for($i=0;$i<count($data);$i++){
          //     if($data[$i]["Division"]==trim($row->Category)){          
          //       $findCounter    = 1;
          //       $oldV           = $data[$i]["count"];
          //       $data[$i]["count"]    = $oldV+1;          
          //       break;
          //     }
          //   }
          //   if($findCounter==0){
          //     $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
          //   } 
          //   else {
          //     $findCounter  = 0;
          //   }
          // }
          // echo json_encode($data);
          $data = executeBlock($datefilter , 'CategoryWiseSalesPerformanceQtn');
          echo json_encode($data);
          
        }
else if($SubCatparamfilter['SubCategory'])
      {
        
        // $query = new MongoDB\Driver\Query($SubCatparamfilter); 
        // $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSubCatWisePerformanceQtn", $query);//collection RepName and category and promo name
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
        //   echo json_encode($data);
        $data = executeBlock($SubCatparamfilter , 'CategoryWiseSubCatWisePerformanceQtn');
      echo json_encode($data);
      }
 else if($itemcodeparamfilter['Item_Code'])
      {
        
        // $query = new MongoDB\Driver\Query($itemcodeparamfilter); 
        // $rows  = $connection->executeQuery("SaleRepInsight.ToptensellingWiseCategory", $query);//collection RepName and category and promo name
        // $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
        //   echo json_encode($data);
        $data = executeBlock($itemcodeparamfilter , 'ToptensellingWiseCategory');
      echo json_encode($data);
      }
else
    {
  
        // $query = new MongoDB\Driver\Query($datefilter); 
        //   $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSalesPerformanceQtn", $query);
        //   $result = array();
        //   foreach($rows as $row){
        //       for($i=0;$i<count($data);$i++){
        //       if($data[$i]["Division"]==trim($row->Category)){          
        //         $findCounter    = 1;
        //         $oldV           = $data[$i]["count"];
        //         $data[$i]["count"]    = $oldV+1;          
        //         break;
        //       }
        //     }
        //     if($findCounter==0){
        //       $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
        //     } 
        //     else {
        //       $findCounter  = 0;
        //     }
        //   }
        //   echo json_encode($data);
      $data = executeBlock($datefilter , 'CategoryWiseSalesPerformanceQtn');
      echo json_encode($data);
      }


      function executeBlock($queryVar,$collection){
          $rows                       = getData($queryVar,$collection);
          $result                     = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter          = 1;
                $oldV                 = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]               =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter            = 0;
            }
          }
	$dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
        $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);
	return($dataWithDateParam);
 
      }
?>