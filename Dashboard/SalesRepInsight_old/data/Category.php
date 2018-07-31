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
$Promoname = $_GET['ProNameparam'];
$str_explodePromo=explode(",",$Promoname);
$EmpIdname = $_GET['EmpIdparam'];
$SubCatparam = $_GET['SubCatparam'];
$itemcodeparam = $_GET['itemcodeparam'];


$connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");


//$zonefilter['Zone'] = $zonename;
//$statefilter['State'] = $statename;
//$Cityfilter['City'] = $Cityname;
//$Sitefilter['SourceSite'] = $Sitename;
//$promoNamefilter['PromoNo'] = $Promoname;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$zonefilter = array('Zone'=>array('$in'=>$str_explode));
$statefilter = array('State'=>array('$in'=>$str_explodeState));
$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
$Sitefilter = array('SourceSite'=>array('$in'=>$str_explodeSite));
$promoNamefilter = array('PromoNo'=>array('$in'=>$str_explodePromo));

if($zonename)
        {
          $query = new MongoDB\Driver\Query($zonefilter); 
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
        $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
         
        $rows  = $connection->executeQuery("SaleRepInsight.SalesRepNameAndIdwiseCategorywisePromoName", $query); //collection RepNmae,Id,category,promoname
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
       $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
       $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
        $rows  = $connection->executeQuery("SaleRepInsight.PromoNameWiseCatWisePerformanceQtn", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
        $rows  = $connection->executeQuery("SaleRepInsight.CategoryWiseSubCatWisePerformanceQtn", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
        $rows  = $connection->executeQuery("SaleRepInsight.ToptensellingWiseCategory", $query);//collection RepName and category and promo name
        $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
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
          $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNamesWiseCategory", $query);
          $result = array();
          foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
              if($data[$i]["Division"]==trim($row->Category)){          
                $findCounter    = 1;
                $oldV           = $data[$i]["count"];
                $data[$i]["count"]    = $oldV+1;          
                break;
              }
            }
            if($findCounter==0){
              $data[$i]     =  array("Division"=>trim($row->Category),"count"=>1 );
            } 
            else {
              $findCounter  = 0;
            }
          }
          echo json_encode($data);
      }
?>
