<?php

$param = $_GET['param'];
$Stateparam = $_GET['Stateparam'];
$str_explodeState=explode(",",$Stateparam);
$EmpIDname = $_GET['EmpIdparam'];
$cityname = $_GET['cityparam'];
$str_explodeCity=explode(",",$cityname);
$zonename = $_GET['zoneparam'];
$str_explode=explode(",",$zonename);
$Sitename = $_GET['Siteparam'];
$str_explodeSite=explode(",",$Sitename);
$categoryname = $_GET['categoryparam'];
$str_explodeCatgory=explode(",",$categoryname);
$YesNoparam = $_GET['YesNoparam'];
$SubCatparam = $_GET['SubCatparam'];
$Promoname = $_GET['ProNameparam'];
$str_explodePromo=explode(",",$Promoname);
$itemcodeparam = $_GET['itemcodeparam'];
$startDate = $_GET['startDate'];//01-Jan-17
$endDate = $_GET['endDate'];//31-Jan-17
$miliStartDate = strtotime($startDate);
$miliEndDate = strtotime($endDate);

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

//$miliDateofDay = strtotime($Dateofday);

$EmpIDfilter['SalesRepNameid'] = $EmpIDname;
//$cityefilter['City'] = $cityname;
//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $Stateparam;
//$Sitefilter['SourceSite'] = $Sitename;
//$catefilter['Category'] = $categoryname;
$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
//$promoNamefilter['PromoNo'] = $Promoname;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

//$mongoDateofDay =  new \MongoDB\BSON\UTCDateTime($miliDateofDay*1000);
$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));
//$datefilterday=array('date'=> array('$gte' => $mongoDateofDay));

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$cityefilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));

if ($zonename){
$query = new MongoDB\Driver\Query($zonefilter); 
$rows  = $connection->executeQuery("SaleRepInsight.ZoneWisePoSTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
else if ($Stateparam){
$query = new MongoDB\Driver\Query($statefilter); 
$rows  = $connection->executeQuery("SaleRepInsight.StateWisePoSTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
else if ($cityname){
$query = new MongoDB\Driver\Query($cityefilter); 
$rows  = $connection->executeQuery("SaleRepInsight.CityWisePoSTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
else if ($Sitename){
$query = new MongoDB\Driver\Query($Sitefilter); 
$rows  = $connection->executeQuery("SaleRepInsight.PosTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
else if($categoryname)
{

  $query = new MongoDB\Driver\Query($catefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.CategoryWisePoSTargetAchievement", $query);//2nd collection

          $result = array();
          foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
          echo json_encode($data);

}
else if ($EmpIDfilter['SalesRepNameid']){
$query = new MongoDB\Driver\Query($EmpIDfilter); 
$rows  = $connection->executeQuery("SaleRepInsight.SalesRepWisePoSTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);

}
else if($YesNoparamfilter['CustomerMobile'])
{
  $query                = new MongoDB\Driver\Query($YesNoparamfilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.CustomerDetalilsWisePoSTargetAchievement", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}
else if($startDate && $endDate){

  $query = new MongoDB\Driver\Query($datefilter); 
  $rows  = $connection->executeQuery("SaleRepInsight.DateWisePoSTargetAchievement", $query);
  $result = array();
  foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
else if($SubCatparamfilter['SubCategory'])
{
  $query                = new MongoDB\Driver\Query($SubCatparamfilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.SubCategoryWisePoSTargetAchievement", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}
else if($Promoname)
  {
    $query = new MongoDB\Driver\Query($promoNamefilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWisePoSTargetAchievement", $query);//2nd collections
          $result = array();
          foreach($rows as $row){
            for($i=0;$i<count($data);$i++){
            if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
              $findCounter    = 1;
              $oldV           = $data[$i]["Actual"];
              $data[$i]["Actual"]    = $oldV+$row->Actual;          
              break;
            }
          }
          if($findCounter==0){
            $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
          } else {
            $findCounter  = 0;
          }
        }
          echo json_encode($data);
  }
  else if($itemcodeparamfilter['Item_Code'] )
  {
    $query = new MongoDB\Driver\Query($itemcodeparamfilter); 
    $rows  = $connection->executeQuery("SaleRepInsight.TopTensellingWisePosTargetAchievement", $query);//2nd collections
          $result = array();
          foreach($rows as $row){
            for($i=0;$i<count($data);$i++){
            if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
              $findCounter    = 1;
              $oldV           = $data[$i]["Actual"];
              $data[$i]["Actual"]    = $oldV+$row->Actual;          
              break;
            }
          }
          if($findCounter==0){
            $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
          } else {
            $findCounter  = 0;
          }
        }
          echo json_encode($data);
  }
else
{
$query = new MongoDB\Driver\Query([]); 
$rows  = $connection->executeQuery("SaleRepInsight.PosTargetAchievement", $query);
$result = array();
foreach($rows as $row){
    for($i=0;$i<count($data);$i++){
    if($data[$i]["SourceSite"]==trim($row->SourceSite)){          
      $findCounter    = 1;
      $oldV           = $data[$i]["Actual"];
      $data[$i]["Actual"]    = $oldV+$row->Actual;          
      break;
    }
  }
  if($findCounter==0){
    $data[$i]     =  array("SourceSite"=>trim($row->SourceSite), "Actual"=>trim($row->Actual));
  } else {
    $findCounter  = 0;
  }
}
echo json_encode($data);
}
?>
