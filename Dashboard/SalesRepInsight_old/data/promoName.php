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
$EmpIdname = $_GET['EmpIdparam'];
$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");


//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$Sitefilter['SourceSite'] = $Sitename;
$catefilter['Category'] = $categoryname;
$Empfilter['SalespersonId'] = $EmpIdname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));

if($zonename)
{
  $query = new MongoDB\Driver\Query($zonefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWisePromoName", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseCatWisePerformanceQtn", $query);//collection RepName and category and promo name
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}

else if($Empfilter['SalespersonId'])
{
  $query = new MongoDB\Driver\Query($Empfilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSRWiseContributionValue", $query);//collection RepName and category and promo name
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSubCatWisePerformanceQtn", $query);//collection RepName and category and promo name
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
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

          $rows  = $connection->executeQuery("SaleRepInsight.TopTenSellingWisePromoName", $query);//collection RepName and category and promo name
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromeNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromeNo),"PromoName"=>trim($row->PromeName),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSalesPerformanceValue", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["PromoNo"]==trim($row->PromoNo)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("PromoNo"=>trim($row->PromoNo),"PromoName"=>trim($row->PromoName),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}

?>
