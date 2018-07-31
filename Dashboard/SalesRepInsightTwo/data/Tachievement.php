<?php
session_start();

$param = $_GET['param'];
if($param=="YES"){
  unset($_SESSION["stDate"]);
  unset($_SESSION["endDate"]);
  session_destroy();
}
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
$POSTypeparam = $_GET['POSTypeparam'];
$str_explodePOSType=explode(",",$POSTypeparam);
$startDate = $_GET['startDate'];//01-Jan-17
$endDate = $_GET['endDate'];//31-Jan-17
if(!empty($_GET['startDate'])){
  $_SESSION['stDate'] =  $_GET['startDate'];
}

if(!empty($_GET['endDate'])){
 $_SESSION['endDate']= $_GET['endDate'];
}


$miliStartDate = strtotime($startDate);
$miliEndDate = strtotime($endDate);
$miliStartDateSession = strtotime($_SESSION['stDate']);
$miliEndDateSession = strtotime($_SESSION['endDate']);

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

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);
$datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateposfilterSession=array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datepromofilterSession=array('PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempfilterSession=array('SalesRepNameid'=>$EmpIDname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
//echo "<pre>"; print_r($dateempfilterSession);die;
//$datefilterday=array('date'=> array('$gte' => $mongoDateofDay));

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$cityefilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));


if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datezonefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWisePoSTargetAchievement", $query);
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
else if ($Stateparam && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datestatefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWisePoSTargetAchievement", $query);
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
else if ($cityname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecityfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWisePoSTargetAchievement", $query);
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
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($dateposfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWisePoSTargetAchievement", $query);
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
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datessitefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWisePoSTargetAchievement", $query);
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
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCategoryWisePoSTargetAchievement", $query);
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
else if ($Promoname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datepromofilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePromoWisePoSTargetAchievement", $query);
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
else if ($EmpIDfilter['SalesRepNameid'] && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($EmpIDfilter['SalesRepNameid']);die;

	$query = new MongoDB\Driver\Query($dateempfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWisePoSTargetAchievement", $query);
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
else if ($POSTypeparam){
$query = new MongoDB\Driver\Query($POSTypefilter); 
$rows  = $connection->executeQuery("SaleRepInsight.PosTypeWisePoSTargetAchievement", $query);
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
else if ($zonename){
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