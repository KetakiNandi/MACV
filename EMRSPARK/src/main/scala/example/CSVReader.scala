package example

import java.text.SimpleDateFormat
import java.util.{ArrayList, Calendar}
import org.apache.http.{HttpStatus, NameValuePair}
import org.apache.http.message.BasicNameValuePair
import org.apache.log4j.{Level, Logger}
import org.apache.spark.{SparkConf, SparkContext}
import scala.util.Try


object CSVReader {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""), Try(fields(18)) getOrElse (""))

  }

  def main(args: Array[String]) {

    Logger.getLogger("ORG").setLevel(Level.ERROR)

    val conf = new SparkConf()

    conf.setAppName("FirstEMRApp").setMaster("local[2]").set("spark.executor.memory","1g");

    val sc = new SparkContext(conf)

    //val SaleRepdata = sc.textFile("s3n://macv/Sales/SalesDetails18.csv")

    val SaleRepdata = sc.textFile("../SalesDetails18.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._1.toString.substring(6,10),s._2)).map(s=>(s._1+"@"+s._3,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1)))

    val TotalFiltercount=checkyear17.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_)

    val finalResult=TotalFiltercount.map(s=>(s._1,s._2))
    val results = finalResult.collect()

   // results.foreach(println)

    //For API Call

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val nameValuePairs = new ArrayList[NameValuePair]
      nameValuePairs.add(new BasicNameValuePair("TimeStamp",today.getTime.toString));
      nameValuePairs.add(new BasicNameValuePair("date", df.parse(rdd._1).getTime.toString));
      nameValuePairs.add(new BasicNameValuePair("Amount", rdd._2.toString));
      nameValuePairs.add(new BasicNameValuePair("ColName", "SalesperformanceValue"));
      APICall.APICallPart(nameValuePairs)

    })

  }

}
