<?php 

$param = $_GET['param'];
$zonename = $_GET['zoneparam'];
$str_explode=explode(",",$zonename);
$statename = $_GET['Stateparam'];
$str_explodeState=explode(",",$statename);
$Cityname = $_GET['Cityparam'];
$str_explodeCity=explode(",",$Cityname);
$Sitename = $_GET['Siteparam'];
$str_explodeSite=explode(",",$Sitename);
$categoryname = $_GET['categoryparam'];
$str_explodeCatgory=explode(",",$categoryname);
$Promoname = $_GET['ProNameparam'];
$str_explodePromo=explode(",",$Promoname);
$SubCatparam = $_GET['SubCatparam'];
$EmpIdname = $_GET['EmpIdparam'];
$itemcodeparam = $_GET['itemcodeparam'];
$POSTypeparam = $_GET['POSTypeparam'];
$str_explodePOSType=explode(",",$POSTypeparam);


$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$Sitefilter['SourceSite'] = $Sitename;
//$catefilter['Category'] = $categoryname;
//$promoNamefilter['PromoNo'] = $Promoname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));
$POSTypefilter = array('PosType'=>array('$in'=>$str_explodePOSType));

if($POSTypeparam)
{

  $query = new MongoDB\Driver\Query($POSTypefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.PosTypeWiseZSCSWiseRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.SalesRepNameAndIdwiseCategorywisePromoName", $query);//connection SaleRep Category and promoname
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSRWiseContributionValue", $query);//connection SaleRep Category and promoname
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalespersonId)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalespersonId),"EmpName"=>trim($row->Salesperson),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSubCatWisePerformanceQtn", $query);//connection SaleRep Category and promoname
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);//connection SaleRep Category and promoname
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWiseSalesRep", $query);//connection SaleRep Category and promoname
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["EmpID"]==trim($row->SalesRepNameid)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }
?>
