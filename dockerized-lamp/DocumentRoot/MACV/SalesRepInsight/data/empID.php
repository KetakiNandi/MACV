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
$POSTypeparam = $_SESSION['POSTypes'];
$str_explodePOSType=explode(",",$POSTypeparam);
$Sitename = $_SESSION['Sites'];
$str_explodeSite=explode(",",$Sitename);
$categoryname = $_SESSION['Categories'];
$str_explodeCatgory=explode(",",$categoryname);
$Promoname = $_SESSION['ProNames'];
$str_explodePromo=explode(",",$Promoname);
$EmpIdname = $_SESSION['EMP'];
$startDate = $_SESSION['stDate'];//01-Jan-17
$endDate = $_SESSION['endDate'];//31-Jan-17

//////LATER/////////
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

$SubCatparamfilter['SubCategory'] = $SubCatparam;
$Empfilter['SalesRepNameid'] = $EmpIdname;
$itemcodeparamfilter['Item_Code'] = $itemcodeparam;

$mongoStartDateSession =  new \MongoDB\BSON\UTCDateTime($miliStartDateSession*1000);
$mongoEndDateSession =  new \MongoDB\BSON\UTCDateTime($miliEndDateSession*1000);

/////////PROMO///////////
 $datecatpromofilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecatpromopostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));

 //////CAT//////
 $datecatfilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecatpostypefilterSession=array('Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////////SOURCESITE////////////
 $str_explodeSourceSiteSession=explode(",",$_SESSION['Sites']);
 $datessitefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatfilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpromofilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datessitepostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datessitecatpostypefilterSession=array('SourceSite'=>array('$in'=>$str_explodeSourceSiteSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


 ///////CITY/////////
 $str_explodeCitySession=explode(",",$_SESSION['cities']);
 $datecityfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatfilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpromofilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datecitypostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datecitycatpostypefilterSession=array('City'=>array('$in'=>$str_explodeCitySession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 
 ///////STATE/////////
 $str_explodeStateSession=explode(",",$_SESSION['states']);
 $datestatefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatfilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpromofilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datestatepostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datestatecatpostypefilterSession=array('State'=>array('$in'=>$str_explodeStateSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));

 //////ZONE//////////
 $str_explodeSession=explode(",",$_SESSION['zones']);
 $datezonefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatfilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpromofilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession),'PromoNo'=>array('$in'=>$str_explodePromo));
 $datezonepostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
 $datezonecatpostypefilterSession=array('Zone'=>array('$in'=>$str_explodeSession),'Category'=>array('$in'=>$str_explodeCatgory),'PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));
//echo "<pre>"; print_r($datezonecatpromofilterSession);die;

////POSTYPE/////
 $datepostypefilterSession = array('PosType'=>array('$in'=>$str_explodePOSType),'date'=> array('$gte' => $mongoStartDateSession, '$lte' => $mongoEndDateSession));


if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
      {
      
        $result   =   executeBlock($datessitecatpostypefilterSession , 'datesourcesitecatpostypeemp');
       echo $result;
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
     
        $result   =   executeBlock($datessitepostypefilterSession , 'datesourcesiteempidpostype');
        echo $result;
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
      {
      
        $result   =   executeBlock($datessitecatpromofilterSession , 'DatesourcesitecatpromoEmpid');
        echo $result;
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
      {
     
         $result   =   executeBlock($datessitecatfilterSession , 'DatesourcesitecatEmpid');
       echo $result;
      }
else if($Sitename && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
      
        $result   =   executeBlock($datessitefilterSession , 'DatesourcesiteEmpid');
        echo $result;
      }
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  $result   =   executeBlock($datecitycatpostypefilterSession , 'datecitycatpostypeemp');
       echo $result;
}
else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  $result   =   executeBlock($datecitypostypefilterSession , 'datecityempidpostype');
        echo $result;
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  $result   =   executeBlock($datecitycatpromofilterSession , 'DatecitycatpromoEmpid');
  echo $result;
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
    $result   =   executeBlock($datecitycatfilterSession , 'DatecitycatEmpid');
    echo $result;
}

else if($Cityname && $_SESSION['stDate'] && $_SESSION['endDate'])
{
        $result   =   executeBlock($datecityfilterSession , 'DatecityEmpid');
        echo $result;
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
        $result   =   executeBlock($datestatecatpostypefilterSession , 'datestatecatpostypeemp');
        echo $result;
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  $result   =   executeBlock($datestatepostypefilterSession , 'datestateempidpostype');
        echo $result;
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  $result   =   executeBlock($datestatecatpromofilterSession , 'DatestatecatpromoEmpid');
        echo $result;
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  $result   =   executeBlock($datestatecatfilterSession , 'DatestatecatEmpid');
        echo $result;
}
else if($statename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
  $result   =   executeBlock($datestatefilterSession , 'DatestateEmpid');
       echo $result;
}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $POSTypeparam)
{
  $result   =   executeBlock($datezonecatpostypefilterSession , 'datezonecatpostypeemp');
       echo $result;
}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
{
  $result   =   executeBlock($datezonepostypefilterSession , 'datezoneempidpostype');
        echo $result;

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname && $Promoname)
{
  $result   =   executeBlock($datezonecatpromofilterSession , 'DatezonecatpromoEmpid');
        echo $result;
}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'] && $categoryname)
{
  $result   =   executeBlock($datezonecatfilterSession , 'DatezonecatEmpid');
       echo $result;

}
else if($zonename && $_SESSION['stDate'] && $_SESSION['endDate'])
{
        $result   =   executeBlock($datezonefilterSession , 'DatezoneEmpid');
       echo $result;

}
else if($Promoname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
      
        $result   =   executeBlock($datecatpromopostypefilterSession , 'datecatemppromopostype');
        echo $result;
      }
else if($Promoname && $categoryname && $_SESSION['stDate'] && $_SESSION['endDate']){
      $result   =   executeBlock($datecatpromofilterSession , 'DateEmpIdPromoNameWiseCategorywisePerformanceQtn');
        echo $result;
      }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'] && $POSTypeparam)
      {
     
        $result   =   executeBlock($datecatpostypefilterSession , 'datecatemppostype');
       echo $result;
      }
else if($categoryname && $_SESSION['stDate'] && $_SESSION['endDate'])
      {
     
        $result   =   executeBlock($datecatfilterSession , 'DateWiseEmpIdWiseCategorywisePerformanceQtn');
    echo $result;
      }
else if($POSTypeparam && $_SESSION['stDate'] && $_SESSION['endDate'])
  {
    $result   =   executeBlock($datepostypefilterSession , 'datecatemppostype');
    echo $result;
	   
  }
else if($startDate && $endDate)
{
  $result   =   executeBlock($datefilter , 'SalesRepWiseSalesPerformanceQtn');
          echo $result;
}

else if($SubCatparamfilter['SubCategory'])
      {
        $result   =   executeBlock($SubCatparamfilter , 'SalesRepWiseSubCatWisePerformanceQtn');
          echo $result;
      }

      else if($Empfilter['SalesRepNameid'])
      {
        $result   =   executeBlock($Empfilter , 'ZoneWiseStateWiseCityWiseSourceSiteNamesSalesRepName');
          echo $result;
      }
 else if($itemcodeparamfilter['Item_Code'])
      {
        $result   =   executeBlock($itemcodeparamfilter , 'TopTenSellingWiseSalesRep');
          echo $result;
      }
else
      {
          $result   =   executeBlock($datefilter , 'SalesRepWiseSalesPerformanceQtn');
          echo $result;
      }


      function executeBlock($queryVar,$collection){

          $rows = getData($queryVar,$collection);
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
              
              $data[$i]     =  array("EmpID"=>trim($row->SalesRepNameid),"EmpName"=>trim($row->SalesRepName),"count"=>1);
            } 
            else {
              $findCounter  = 0;
            }
          }

 $dateParam = array("sessionzone"=>$_SESSION['zones'],"sessionstates"=>$_SESSION['states'],"sessioncities"=>$_SESSION['cities'],"stDate"=>$_SESSION['stDate'],"endDate"=>$_SESSION['endDate']);
          $dataWithDateParam = array("dateParam"=>$dateParam,"data"=>$data);

        
  return json_encode($dataWithDateParam);


}
?>