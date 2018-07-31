 <?php 
//error_reporting(E_ALL);
 // echo "string";exit;
 $connection = new MongoDB\Driver\Manager("mongodb://127.0.0.1/");

 $filter = array('State'=>array('$in'=>array('Gujarat','Kerala')));

 $query = new MongoDB\Driver\Query($filter); 

 $rows  = $connection->executeQuery("SaleRepInsight.ZoneWiseStateWiseCityWiseSourceSiteNames", $query);

      $result = array();
      foreach($rows as $row){
          for($i=0;$i<count($data);$i++){
          if($data[$i]["State"]==trim($row->State)){          
            $findCounter    = 1;
           // $oldV           = $data[$i]["count"];
           // $data[$i]["count"]    = $oldV+1;          
            break;
          }
        }
        if($findCounter==0){
          $data[$i]     =  array("State"=>trim($row->State));
        } 
        else {
          $findCounter  = 0;
        }
      }
      echo json_encode($data);      
?>