  <?php
session_start();

$param = $_GET['param'];
if($param=="YES"){
  unset($_SESSION["stDate"]);
  unset($_SESSION["endDate"]);
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  session_destroy();
}
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

 $zonename = $_GET['zoneparam'];
 $str_explode=explode(",",$zonename);
 
 if(!empty($_GET['zoneparam'])){
  $_SESSION['zones'] =  $_GET['zoneparam'];
}
 $str_explodeSession=explode(",",$_SESSION['zones']);
//echo "<pre>"; print_r($str_explodeSession);die;
 $Sitename = $_GET['Siteparam'];
 $str_explodeSite=explode(",",$Sitename);
 $EmpIdname = $_GET['EmpIdparam'];
 $categoryname = $_GET['categoryparam'];
 $str_explodeCatgory=explode(",",$categoryname);
 $Promoname = $_GET['ProNameparam'];
 $str_explodePromo=explode(",",$Promoname);
 $YesNoparam = $_GET['YesNoparam'];
 $SubCatparam = $_GET['SubCatparam'];
 $itemcodeparam = $_GET['itemcodeparam'];
$POSTypeparam = $_GET['POSTypeparam'];
$str_explodePOSType=explode(",",$POSTypeparam);
if(!empty($_GET['startDate'])){
  $_SESSION['stDate'] =  $_GET['startDate'];
 
}

if(!empty($_GET['endDate'])){
 $_SESSION['endDate']= $_GET['endDate'];
}

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

$miliStartDateSession = strtotime($_SESSION['stDate']);
$miliEndDateSession = strtotime($_SESSION['endDate']);

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);
$datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateposfilterSession=array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datepromofilterSession=array('PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempfilterSession=array('SalesRepNameid'=>$EmpIdname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

$datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
//echo "<pre>"; print_r($datezonecatfilterSession);die;
//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$zonefilter['Zone'] = $zonename;
//$Sitefilter['SourceSite'] = $Sitename;

$Empfilter['SalesRepNameid'] = $EmpIdname;
//$catefilter['Category'] = $categoryname;
//$promoNamefilter['PromoNo'] = $Promoname;
$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));

 if ($str_explodeSession && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION['stDate']);die;

	$query = new MongoDB\Driver\Query($datezonecatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateZoneCategoryWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($str_explodeStateSession && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION['stDate']);die;

	$query = new MongoDB\Driver\Query($datestatecatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateStateCategoryWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($str_explodeCitySession && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION['stDate']);die;

	$query = new MongoDB\Driver\Query($datecitycatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateCityCategoryWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datezonefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($statename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datestatefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($Cityname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecityfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($dateposfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datessitefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCategoryWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($Promoname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datepromofilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePromoWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
         $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}
else if ($Empfilter['SalesRepNameid'] && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($EmpIDfilter['SalesRepNameid']);die;

	$query = new MongoDB\Driver\Query($dateempfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWiseSalesAVGQtnSoldPerDay", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          $dateParam = array("stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

          echo json_encode($dataWithDateParam);
}

else if($POSTypeparam)
{

    $query = new MongoDB\Driver\Query($POSTypefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseSalesAVGQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}

else if($zonename)
{

    $query = new MongoDB\Driver\Query($zonefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseSalesAVGQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}

else if($statename)
{

    $query = new MongoDB\Driver\Query($statefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.StateWiseSalesAVGQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}
else if($Cityname)
{

    $query = new MongoDB\Driver\Query($Cityfilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.CityWiseSalesAVGQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}
else if($Sitename)
{

    $query = new MongoDB\Driver\Query($Sitefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.AvgQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
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
        $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSalesAVGQtnSoldPerDay", $query);//2nd Connections
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}

else if($categoryname)
{
        $query = new MongoDB\Driver\Query($catefilter); 

        $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSalesAVGQtnSoldPerDay", $query);//2nd Connections
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if($Promoname)
{
        $query = new MongoDB\Driver\Query($promoNamefilter); 
        $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSalesAVGQtnSoldPerDay", $query);//2nd Connections
          $result = array();
         foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}

else if($YesNoparamfilter['CustomerMobile'])
{
  $query                = new MongoDB\Driver\Query($YesNoparamfilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.CustomerDetailsWiseSalesAVGQtnSoldPerDay", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}
else if($SubCatparamfilter['SubCategory'])
{
  $query                = new MongoDB\Driver\Query($SubCatparamfilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.SubCategoryWiseSalesAVGQtnSoldPerDay", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}
else if($itemcodeparamfilter['Item_Code'])
{
  $query                = new MongoDB\Driver\Query($itemcodeparamfilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.TopTensellingWiseAvgQtnSoldPerDay", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}

else
  {

  $query = new MongoDB\Driver\Query([]); 

          $rows  = $connection->executeQuery("SaleRepInsight.AvgQtnSoldPerDay", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PosCode"]==trim($row->PosCode)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+$row->Quantity;
                           
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PosCode"=>trim($row->PosCode),"PosName"=>trim($row->SourceSite),"count"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}

?>

