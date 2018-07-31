
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
 $itemcodeparam = $_GET['itemcodeparam'];
 $startDate = $_GET['startDate'];//01-Jan-17
 $endDate = $_GET['endDate'];//31-Jan-17
 $miliStartDate = strtotime($startDate);
 $miliEndDate = strtotime($endDate);

 $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

 $mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
 $mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
 $datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$zonefilter['Zone'] = $zonename;
//$Sitefilter['SourceSite'] = $Sitename;
$Empfilter['SalesRepNameid'] = $EmpIdname;
//$catefilter['Category'] = $categoryname;
//$promoNamefilter['PromoNo'] = $Promoname;
$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));

if($startDate && $endDate)
{
  $query = new MongoDB\Driver\Query($datefilter); 

          $rows  = $connection->executeQuery("SaleRepInsight.DateWiseSubCatWisePerformanceQtn", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
        $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseSubCatWisePerformanceQtn", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
        $rows  = $connection->executeQuery("SaleRepInsight.StateWiseSubCatWisePerformanceQtn", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
        $rows  = $connection->executeQuery("SaleRepInsight.CityWiseSubCatWisePerformanceQtn", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
        $rows  = $connection->executeQuery("SaleRepInsight.SourceSiteSubCatWisePerformanceQtn", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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

        $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSubCatWisePerformanceQtn", $query);//2nd collection
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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

        $rows  = $connection->executeQuery("SaleRepInsight.SalesRepWiseSubCatWisePerformanceQtn", $query);//2nd collection
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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

        $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseSubCatWisePerformanceQtn", $query);//2nd collection
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
  
  $rows                 = $connection->executeQuery("SaleRepInsight.CustomerDetailsWiseSubCatWisePerformanceQtn", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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
  
  $rows                 = $connection->executeQuery("SaleRepInsight.ToptensellingWiseSubCategory", $query);//2nd Collection saleRep,cat,pn
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){    
                $findCounter    = 1;
                $oldV           = $data[$i]["Revenue"];
                $data[$i]["Revenue"]    = $oldV+$row->Quantity;      
                
                break;
              }
            }
            if($findCounter==0){
            $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
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

          $rows  = $connection->executeQuery("SaleRepInsight.SubCategorywisePerformanceQuantity", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Category"]==trim($row->SubCategory)){          
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Category"=>trim($row->SubCategory),"Revenue"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);

}

?>