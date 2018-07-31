<?php 
session_start();
$param = $_GET['param'];
if($param=="YES"){
  //unset($_SESSION["stDate"]);
  //unset($_SESSION["endDate"]);
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  session_destroy();
}
$zonename = $_GET['zoneparam'];
$str_explode=explode(",",$zonename);

if(!empty($_GET['zoneparam'])){
  $_SESSION['zones'] =  $_GET['zoneparam'];
}
$str_explodeSession=explode(",",$_SESSION['zones']);

$statename = $_GET['Stateparam'];
$str_explodeState=explode(",",$statename);

if(!empty($_GET['Stateparam'])){
  $_SESSION['states'] =  $_GET['Stateparam'];
}
$str_explodeStateSession=explode(",",$_SESSION['states']);

$Cityname = $_GET['Cityparam'];
$str_explodeCity=explode(",",$Cityname);

if(!empty($_GET['Cityparam'])){
  $_SESSION['cities'] =  $_GET['Cityparam'];
}
$str_explodeCitySession=explode(",",$_SESSION['cities']);

$Sitename = $_GET['Siteparam'];
$str_explodeSite=explode(",",$Sitename);
$Promoname = $_GET['ProNameparam'];
$str_explodePromo=explode(",",$Promoname);
$EmpIdname = $_GET['EmpIdparam'];
$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];
$POSTypeparam = $_GET['POSTypeparam'];
$str_explodePOSType=explode(",",$POSTypeparam);


$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");


//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$Sitefilter['SourceSite'] = $Sitename;
//$promoNamefilter['PromoNo'] = $Promoname;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));

if($POSTypeparam)
        {
          $query = new MongoDB\Driver\Query($POSTypefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseZSCSWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);
	  $dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

        }
else if($zonename)
        {
          $query = new MongoDB\Driver\Query($zonefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);
	  $dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);

        }

  else if($statename)
        {

          $query = new MongoDB\Driver\Query($statefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);
          $dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
        }

  else if($Cityname)
      {
        
        $query = new MongoDB\Driver\Query($Cityfilter); 
        $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);
          $dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }

else if($Empfilter['SalesRepNameid'])
      {
        $query = new MongoDB\Driver\Query($Empfilter);
         
        $rows  = $connection->executeQuery("SaleRepInsight.SalesRepNameAndIdwiseCategorywisePromoName", $query); //collection RepNmae,Id,category,promoname
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);  
	$dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }

else if($Sitename)
     {
   
       $query = new MongoDB\Driver\Query($Sitefilter); 
       $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
       $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          //echo json_encode($data);
	  $dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }

else if($Promoname)
      {
        
        $query = new MongoDB\Driver\Query($promoNamefilter); 
        $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseCatWisePerformanceQtn", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
         // echo json_encode($data);
	$dateParam = array("sessionzone"=>$_SESSION['zones']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
      }
else if($SubCatparamfilter['SubCategory'])
      {
        
        $query = new MongoDB\Driver\Query($SubCatparamfilter); 
        $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSubCatWisePerformanceQtn", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }
      else if($itemcodeparamfilter['Item_Code'])
      {
        
        $query = new MongoDB\Driver\Query($itemcodeparamfilter); 
        $rows  = $connection->executeQuery("SaleRepInsight.ToptensellingWiseCategory", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }
else
    {
  
        $query = new MongoDB\Driver\Query([]); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }
?>
