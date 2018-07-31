<?php 

$param = $_GET['param'];
$statename = $_GET['Stateparam'];
$str_explodeState=explode(",",$statename);
 $Cityname = $_GET['Cityparam'];
 $str_explodeCity=explode(",",$Cityname);
 $zonename = $_GET['zoneparam'];
 $str_explode=explode(",",$zonename);
  $categoryname = $_GET['categoryparam'];
  $str_explodeCatgory=explode(",",$categoryname);
  $EmpIdname = $_GET['EmpIdparam'];
  $Promoname = $_GET['ProNameparam'];
  $str_explodePromo=explode(",",$Promoname);
$SubCatparam = $_GET['SubCatparam'];
$Sitename = $_GET['Siteparam'];
$itemcodeparam = $_GET['itemcodeparam'];

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$zonefilter['Zone'] = $zonename;
$catefilter['Category'] = $categoryname;
$Empfilter['SalesRepNameid'] = $EmpIdname;
//$promoNamefilter['PromoNo'] = $Promoname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$Sitefilter['SourceSite'] = $Sitename;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));

if($zonename)
{
    $query = new MongoDB\Driver\Query( $zonefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
           
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }

  else if($statename)
  {
    $query = new MongoDB\Driver\Query( $statefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);


          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }

else if($Cityname)
  {
    $query = new MongoDB\Driver\Query( $Cityfilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);


          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }

  else if($Empfilter['SalesRepNameid'])
  {
    $query = new MongoDB\Driver\Query( $Empfilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);  //collections zone state souceSite saleRepname


          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }

  else if($categoryname)
  {
    $query = new MongoDB\Driver\Query( $catefilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
      $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query); //category collections
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }

  else if($Promoname)
  {
    $query = new MongoDB\Driver\Query( $promoNamefilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query); //PromoName collections
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }
else if($SubCatparamfilter['SubCategory'])
  {
    $query = new MongoDB\Driver\Query( $SubCatparamfilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.SourceSiteSubCatWisePerformanceQtn", $query); //PromoName collections
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }
else if($Sitefilter['SourceSite'])
  {
    $query = new MongoDB\Driver\Query( $Sitefilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.PoscodeWisePosNameWiseQtn", $query); //PromoName collections
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
  }
else if($itemcodeparamfilter['Item_Code'])
  {
    $query = new MongoDB\Driver\Query( $itemcodeparamfilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.TopTensellingWiseSalespersonWiseContributionValue", $query); //PromoName collections
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("SourceSite"=>trim($row->SourceSite),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
    }
?>
