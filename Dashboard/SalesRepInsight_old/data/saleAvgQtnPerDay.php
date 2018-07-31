  <?php

 $param = $_GET['param'];
 $statename = $_GET['Stateparam'];
 $str_explodeState=explode(",",$statename);
 $Cityname = $_GET['Cityparam'];
 $str_explodeCity=explode(",",$Cityname);
 $zonename = $_GET['zoneparam'];
 $str_explode=explode(",",$zonename);
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

$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

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

if($zonename)
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
