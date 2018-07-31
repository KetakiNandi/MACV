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
 $startDate = $_GET['startDate'];//01-Jan-17
 $endDate = $_GET['endDate'];//31-Jan-17
 $miliStartDate = strtotime($startDate);
 $miliEndDate = strtotime($endDate);

$mng = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$zonefilter['Zone'] = $zonename;
//$Sitefilter['SourceSite'] = $Sitename;
$Empfilter['SRID'] = $EmpIdname;
//$catefilter['Category'] = $categoryname;
//$promoNamefilter['PromoNo'] = $Promoname;
$YesNoparamfilter['CustomerMobile'] = $YesNoparam;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
$mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);

$datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

$zonefilter = array('Zone'=>array('$in'=>$str_explode));

$statefilter = array('State'=>array('$in'=>$str_explodeState));

$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));

$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));

$catefilter = array('Category'=>array('$in'=>$str_explodeCatgory));

$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));

if($startDate && $endDate){
  $query                = new MongoDB\Driver\Query($datefilter);
  $rows                 = $mng->executeQuery("SaleRepInsight.DatewiseQuarterQuantity", $query);
  $data                 = array();
  $findCounter          = 0;
  foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
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
        $query                = new MongoDB\Driver\Query($zonefilter);
        $rows                 = $mng->executeQuery("SaleRepInsight.ZoneWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);

      }

else if($statename)
      {
        $query                = new MongoDB\Driver\Query($statefilter);
        $rows                 = $mng->executeQuery("SaleRepInsight.StateWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);

      }

else if($Cityname)
      {
         $query                = new MongoDB\Driver\Query($Cityfilter);
        $rows                 = $mng->executeQuery("SaleRepInsight.CityWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);

      }

else if($Sitename)
      {
        $query                = new MongoDB\Driver\Query($Sitefilter);

        $rows                 = $mng->executeQuery("SaleRepInsight.SourseSiteWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);

      }

else if($Empfilter['SRID'])
      {
        $query                = new MongoDB\Driver\Query($Empfilter);

        $rows                 = $mng->executeQuery("SaleRepInsight.SalesRepWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);
      }

else if($categoryname)
      {
        $query                = new MongoDB\Driver\Query($catefilter);

        $rows                 = $mng->executeQuery("SaleRepInsight.CategoryWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
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

        $rows                 = $mng->executeQuery("SaleRepInsight.PromoNameWiseSalesperformanceQtnQuarter", $query);
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);
    }

else if($YesNoparamfilter['CustomerMobile'])
      {
        $query                = new MongoDB\Driver\Query($YesNoparamfilter);

        $rows                 = $mng->executeQuery("SaleRepInsight.CustomerDetailsQuarterQuantity", $query);//3rd collections
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
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

        $rows                 = $mng->executeQuery("SaleRepInsight.SubCategoryQuarterQuantity", $query);//3rd collections
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
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

        $rows                 = $mng->executeQuery("SaleRepInsight.TopTenQuarterQuantity", $query);//3rd collections
        $data                 = array();
        $findCounter          = 0;
        foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
        array_walk_recursive($data, function (&$b) { $b = (string)$b; });
        echo json_encode($data);
    }

else{
  $query = new MongoDB\Driver\Query([]); 

          $rows  = $mng->executeQuery("SaleRepInsight.DatewiseQuarterQuantity", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Quarter"]==trim($row->Quarter)){  

               $findCounter    = 1;
              $oldV           = $data[$i]["Quantity"];
              $data[$i]["Quantity"]    = $oldV+$row->Quantity;            
                
                break;
              }


            }
            if($findCounter==0){
              
              $data[$i]     =  array("Quarter"=>trim($row->Quarter),"Quantity"=>trim($row->Quantity));
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
}

?>