  <?php
 session_start();
 $param = $_GET['param'];
 if($param=="YES"){
  unset($_SESSION["stDate"]);
  unset($_SESSION["endDate"]);
  session_destroy();
}
 $statename = $_GET['Stateparam'];
 $str_explodeState=explode(",",$statename);
 $Cityname = $_GET['Cityparam'];
 $str_explodeCity=explode(",",$Cityname);
 $zonename = $_GET['zoneparam'];
 $str_explode=explode(",",$zonename);
 $Sitename = $_GET['Siteparam'];
 $str_explodeSite=explode(",",$Sitename);
 $categoryname = $_GET['categoryparam'];
 $str_explodeCatgory=explode(",",$categoryname);
 $EmpIdname = $_GET['EmpIdparam'];
 $YesNoparam = $_GET['YesNoparam'];
 $SubCatparam = $_GET['SubCatparam'];
 $Promoname = $_GET['ProNameparam'];
 $str_explodePromo=explode(",",$Promoname);
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

$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);
$datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateposfilterSession=array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datessitefilterSession=array('SourcSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$datepromofilterSession=array('PromeNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
$dateempfilterSession=array('SalesRepNameid'=>$EmpIDname,'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
//echo "<pre>"; print_r($dateempfilterSession);die;

//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$zonefilter['Zone'] = $zonename;
//$Sitefilter['SourcSite'] = $Sitename;
//$catefilter['Category'] = $categoryname;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
//$promoNamefilter['PromeNo'] = $Promoname;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourcSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromeNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));

if ($zonename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datezonefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseZoneWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($Stateparam && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datestatefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseStateWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($cityname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecityfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCityWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($dateposfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePosTypeWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($Sitename && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datessitefilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseSourceSiteWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datecatfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseCategoryWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($Promoname && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($_SESSION);die;

	$query = new MongoDB\Driver\Query($datepromofilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWisePromoWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if ($EmpIDfilter['SalesRepNameid'] && $_SESSION['stDate'] && $_SESSION['endDate']){
	//echo "<pre>"; print_r($EmpIDfilter['SalesRepNameid']);die;

	$query = new MongoDB\Driver\Query($dateempfilterSession); 
	$rows  = $connection->executeQuery("SaleRepInsight.DateWiseEmpIdWiseTopTenSellingItemsQtn", $query);
	 $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}
else if($POSTypeparam)
{

  $query = new MongoDB\Driver\Query($POSTypefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseTopTenSellingItemsQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}
else if($startDate && $endDate){
  $query                = new MongoDB\Driver\Query($datefilter);
  $rows                 = $connection->executeQuery("SaleRepInsight.DateWiseTop10SellingItemsQtn", $query);
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

            } 
            else {
              $findCounter  = 0;
            }
          }
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);
  }

else if($zonename)
{

  $query = new MongoDB\Driver\Query($zonefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseTop10SellingItemsQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
              
              break;
              }
          }

        if($findCounter==0){
              
          $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));

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

          $rows  = $connection->executeQuery("SaleRepInsight.StateWiseTop10SellingItemsQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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

          $rows  = $connection->executeQuery("SaleRepInsight.CityWiseTop10SellingItemsQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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

          $rows  = $connection->executeQuery("SaleRepInsight.SourceSiteWiseTop10SellingItemsQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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

      $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseTop10SellingItemsQtn", $query);//2nd collection
         $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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
      $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseTop10SellingItemsQtn", $query);//2nd collection
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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
  
  $rows                 = $connection->executeQuery("SaleRepInsight.CustomerDetailsWiseTop10SellingItemsQtn", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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
  
  $rows                 = $connection->executeQuery("SaleRepInsight.Top10SellingItem", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
  array_walk_recursive($data, function (&$b) { $b = (string)$b; });
  echo json_encode($data);

}
else if($Promoname)
{
  $query                = new MongoDB\Driver\Query($promoNamefilter);
  
  $rows                 = $connection->executeQuery("SaleRepInsight.PromoNameWiseTop10SellingItemsQtn", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){  

                $findCounter    = 1;
                $oldV           = $data[$i]["percentage"];
                $data[$i]["percentage"]    = $oldV+$row->Quantity;
                  
                  break;
              }
          }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
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

          $rows  = $connection->executeQuery("SaleRepInsight.Top10SellingItem", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Group"]==trim($row->Item_Code)){          
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Group"=>trim($row->Item_Code),"PoSName"=>trim($row->SubCategory),"percentage"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}



?>
