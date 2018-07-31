<?php 

  $param = $_GET['param'];
  $zonename = $_GET['zoneparam'];
  $str_explode=explode(",",$zonename);
  $statename = $_GET['Stateparam'];
  $EmpIdname = $_GET['EmpIdparam'];
  $Sitename = $_GET['Siteparam'];
  $categoryname = $_GET['categoryparam'];
  $Promoname = $_GET['ProNameparam'];
  $SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];


$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");


//$zonefilter['Zone'] = $zonename;
$statefilter['State'] = $statename;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$Sitefilter['SourceSite'] = $Sitename;
$catefilter['Category'] = $categoryname;
$promoNamefilter['PromoNo'] = $Promoname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;
$zonefilter = array('Zone'=>array('$in'=>$str_explode));

if($zonename)
  {
    $query = new MongoDB\Driver\Query($zonefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("zone"=>trim($row->Zone),"CIty"=>trim($row->City),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
        }

else if($statefilter['State'])
  {
    $query = new MongoDB\Driver\Query($statefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }

  else if($Empfilter['SalesRepNameid'])
  {
    $query = new MongoDB\Driver\Query($Empfilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }


else if($Sitefilter['SourceSite'])
  {
    $query = new MongoDB\Driver\Query($Sitefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }


else if($catefilter['Category'])
  {
    $query = new MongoDB\Driver\Query($catefilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query); //category collections

          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }


  else if($promoNamefilter['PromoNo'])
  {
    $query = new MongoDB\Driver\Query($promoNamefilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query); //PromoName collections

          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }
else if($SubCatparamfilter['SubCategory'])
  {
    $query = new MongoDB\Driver\Query($SubCatparamfilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        $rows  = $connection->executeQuery("SaleRepInsight.CityWiseSubCatWisePerformanceQtn", $query); //PromoName collections

          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }
  else if($itemcodeparamfilter['Item_Code'])
  {
    $query = new MongoDB\Driver\Query($itemcodeparamfilter); 

         // $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);

        $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWiseCity", $query); //PromoName collections

          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);
  }
else
    {
    $query = new MongoDB\Driver\Query([]); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["CIty"]==trim($row->City)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
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
          echo json_encode($data);

    }
?>
