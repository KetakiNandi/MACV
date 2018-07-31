
var host			=	'localhost:81';

//var host			=	'localhost';


var dir				=	'MACV';
var base_url 		= 	'http://'+host+'/'+dir+'/';

var pCategory       =    encodeURI(base_url+"SalesRepInsight/data/Category.php");
var CWPQ            =    encodeURI(base_url+"SalesRepInsight/data/CategorywisePerformanceQuantity.php");
var szone           =    encodeURI(base_url+"SalesRepInsight/data/CustomerDetailsFilled.php");
var pEmpId          =    encodeURI(base_url+"SalesRepInsight/data/empID.php");
var POSType         =    encodeURI(base_url+"SalesRepInsight/data/POSType.php");
var pName           =    encodeURI(base_url+"SalesRepInsight/data/promoName.php");
var SPQ             =    encodeURI(base_url+"SalesRepInsight/data/SalesPerformanceQtn.php"); 
var SPQQ            =    encodeURI(base_url+"SalesRepInsight/data/SalesPerformanceQtnQuarter.php");
var SPV             =    encodeURI(base_url+"SalesRepInsight/data/SalesPerformanceValue.php"); 

var SPVL            =    encodeURI(base_url+"SalesRepInsight/data/SalesPerformanceValueASP.php");
var SPVQ            =    encodeURI(base_url+"SalesRepInsight/data/SalesPerformanceValueQuarter.php");
var pSsite          =    encodeURI(base_url+"SalesRepInsight/data/SouceSite.php");
var pState          =    encodeURI(base_url+"SalesRepInsight/data/State.php");
var subzone         =    encodeURI(base_url+"SalesRepInsight/data/SubCategorywisePerformanceQuantity.php");
var pZone           =    encodeURI(base_url+"SalesRepInsight/data/Zone.php");
var pCity           =    encodeURI(base_url+"SalesRepInsight/data/city.php");
