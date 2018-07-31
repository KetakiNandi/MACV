<?php 
  require_once(__DIR__.'/config.php');
  session_start();
  $param = $_GET['param'];
  if($param=="YES"){
   unset($_SESSION["stDate"]);
  unset($_SESSION["endDate"]);
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  session_destroy();
  }

  if(!empty($_GET['startDate'])){
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
 $_SESSION['stDate'] =  $_GET['startDate'];
  
}
else
{
  if(!isset($_SESSION['stDate']))
  	$_SESSION['stDate'] =  "01-Jan-17";
}

if(!empty($_GET['endDate'])){
  unset($_SESSION['zones']);
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['endDate']= $_GET['endDate'];
}
else
{
  if(!isset($_SESSION['endDate']))
    $_SESSION['endDate'] =  "31-Dec-17";
}
/*
echo $_SESSION['endDate'];
echo $_SESSION['stDate'];
die;
*/

 if(!empty($_GET['zoneparam'])){
  unset($_SESSION['states']);
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['zones'] =  $_GET['zoneparam'];
  }

 if(!empty($_GET['Stateparam'])){
  unset($_SESSION['cities']);
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['states'] =  $_GET['Stateparam'];
  }

  if(!empty($_GET['Cityparam'])){
  unset($_SESSION['POSTypes']);
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['cities'] =  $_GET['Cityparam'];
  }

  if(!empty($_GET['POSTypeparam'])){
  unset($_SESSION['Sites']);
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['POSTypes'] =  $_GET['POSTypeparam'];
}

if(!empty($_GET['Siteparam'])){
  unset($_SESSION['Categories']);
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['Sites'] =  $_GET['Siteparam'];
}

if(!empty($_GET['categoryparam'])){
  unset($_SESSION['ProNames']);
  unset($_SESSION['EMP']);
  $_SESSION['Categories'] =  $_GET['categoryparam'];
}

if(!empty($_GET['ProNameparam'])){
  unset($_SESSION['EMP']);
  $_SESSION['ProNames'] =  $_GET['ProNameparam'];
}

if(!empty($_GET['EmpIdparam'])){
  $_SESSION['EMP'] =  $_GET['EmpIdparam'];
}

  $zonename = $_SESSION['zones'];
  $str_explode=explode(",",$zonename);
  $statename = $_SESSION['states'];
  $str_explodeState=explode(",",$statename);
  $Cityname = $_SESSION['cities'];
  $str_explodeCity=explode(",",$Cityname);
  $EmpIdname = $_SESSION['EMP'];
  $str_explodeEmpId=explode(",",$EmpIdname);
  $Sitename = $_SESSION['Sites'];
  $str_explodeSite=explode(",",$Sitename);
  $categoryname = $_SESSION['Categories'];
  $str_explodeCatgory=explode(",",$categoryname);
  $Promoname = $_SESSION['ProNames'];
  $str_explodePromo=explode(",",$Promoname);
  $startDate = $_SESSION['stDate'];//01-Jan-17
  $endDate = $_SESSION['endDate'];//31-Jan-17


  $SubCatparam = $_GET['SubCatparam'];
  $itemcodeparam = $_GET['itemcodeparam'];

  $connection = new MongoDB\Driver\Manager("mongodb://mongo:27017");

  $miliStartDate = strtotime($startDate);
  $miliEndDate = strtotime($endDate);
  $miliStartDateSession = $miliStartDate;
  $miliEndDateSession = $miliEndDate;

  $mongoStartDate =  new \MongoDB\BSON\UTCDateTime($miliStartDate*1000);
  $mongoEndDate =  new \MongoDB\BSON\UTCDateTime($miliEndDate*1000);
  $datefilter=array('date'=> array('$gte' => $mongoStartDate, '$lte' => $mongoEndDate));

  $mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
  $mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

  /////////EMP///////////
 //$Empfilter['SalesRepNameid'] = $EmpIdname;
 $dateempfilterSession=array('SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////CATEGORY//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatSRfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatSRpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'PromoNo'=>array('$in'=>$str_explodePromo),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSite),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessiteSRfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 //$Cityfilter = array('City'=>array('$in'=>$str_explodeCity));
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCity),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitySRfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeState),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestateSRfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explode),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezoneSRfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'SalesRepNameid'=>array('$in'=>$str_explodeEmpId),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;


if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname && $Promoname)
  {
    
    $result = executeBlock($datecatSRpromofilterSession , 'datecatemppromopostype' );
        echo $result;
  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
   
    $result = executeBlock($datecatSRfilterSession , 'datecatemppostype' );
        echo $result;
  }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
   
    $result = executeBlock($datessiteSRfilterSession , 'datesourcesiteempidpostype' );
        echo $result;
  }
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
   
    $result = executeBlock($datessitecatpromofilterSession , 'datesourcesitecatpromopostype' );
        echo $result;
  }
else if($Sitename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result = executeBlock($datessitecatfilterSession , 'DateSourceSitePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;
  }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
   

    $result = executeBlock($datessitefilterSession , 'DateSourceSitePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
   

      $result = executeBlock($datecitySRfilterSession , 'datecityempidpostype' );
        echo $result;
  }
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
   
      $result = executeBlock($datecitycatpromofilterSession , 'datecitycatpromopostype' );
        echo $result;
  }
else if($Cityname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    
    $result = executeBlock($datecitycatfilterSession , 'DateCityPosTypeWiseCategorywisePerformanceQtn' );
        echo $result;
  }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
   
    $result = executeBlock($datecityfilterSession , 'DateCityPosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
   

    $result = executeBlock($datestateSRfilterSession , 'datestateempidpostype' );
        echo $result;

  }
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
   
    $result = executeBlock($datestatecatpromofilterSession , 'datestatecatpromopostype' );
        echo $result;

  }
else if($statename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
  

     $result = executeBlock($datestatecatfilterSession , 'DateStatePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

  }
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
   

    $result = executeBlock($datestatefilterSession , 'DateStatePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

  }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $EmpIdname)
  {
   

    $result = executeBlock($datezoneSRfilterSession , 'datezoneempidpostype' );
        echo $result;

        }
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
  
    $result = executeBlock($datezonecatpromofilterSession , 'datezonecatpromopostype' );
        echo $result;

        }
else if($zonename && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
   

    $result = executeBlock($datezonecatfilterSession , 'DateZonePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

        }
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
  
    $result = executeBlock($datezonefilterSession , 'DateZonePosTypeWiseCategorywisePerformanceQtn' );
        echo $result;

        }
else if($EmpIdname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
   
    $result = executeBlock($dateempfilterSession , 'dateemppostype' );
        echo $result;

  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $Promoname)
  {
     $result = executeBlock($datecatpromofilterSession , 'datecatpromopostype' );
        echo $result;

  }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result = executeBlock($datecatfilterSession , 'DatePOSTypeCategoryWiseSubCategorywisePerormanceQtn' );
        echo $result;

  }
else if($startDate && $endDate)
  {

    $result = executeBlock($datefilter , 'PosTypeWiseSalesPerformanceQtn' );
        echo $result;

  }
else if($SubCatparamfilter['SubCategory'])
  {

    $result = executeBlock($SubCatparamfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName' );
        echo $result;

  }
  else if($itemcodeparamfilter['Item_Code'])
  {
    $result = executeBlock($itemcodeparamfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName' );
        echo $result;
  }
else
    {
        $result = executeBlock($datefilter , 'PosTypeWiseSalesPerformanceQtn' );
        echo $result;
    }

    function executeBlock($queryVar,$collection){
            $rows         =   getData($queryVar,$collection);
            $result       =   array();
            $data         =   array();
            $findCounter;
            foreach($rows as $row){
              for($i=0;$i<count($data);$i++){
                if($data[$i]["PosType"]==trim($row->PosType)){
                  $findCounter               = 1;
                  $oldV                      = $data[$i]["count"];
                  $data[$i]["count"]    = $oldV+1;
                      
                 break;
                }
              }
              if($findCounter==0){
                  
                 $data[$i]     =  array("PosType"=>trim($row->PosType),"count"=>1 );
                } 
                else {
                  $findCounter  = 0;
                }
              }

      // return json_encode($data);
  $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities'],"stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
  $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);
  return json_encode($dataWithDateParam);
    }
?>
