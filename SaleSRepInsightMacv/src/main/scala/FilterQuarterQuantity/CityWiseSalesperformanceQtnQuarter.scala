package FilterQuarterQuantity

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object CityWiseSalesperformanceQtnQuarter {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""), Try(fields(17)) getOrElse (""), Try(fields(20)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.CityWiseSalesperformanceQtnQuarter")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.CityWiseSalesperformanceQtnQuarter")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1.toString.substring(3,5),s._2,s._3))

    val TotalFiltercount=checkyear17.map(s=>(s._1+"@"+s._3,s._2.toInt)).reduceByKey(_+_).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2))


    val placeTotalFiltercountQuarter=TotalFiltercount.map(s=>(s._2,s._1,s._3))//state,month,Amount

    val substringplaceTotalFiltercountQuarter=placeTotalFiltercountQuarter.map(s=>(s._1, s._2.toString.substring(0),s._3)).map(s=>(s._1,s._2.toInt,s._3))

    val ChecksubstringInQuarter=substringplaceTotalFiltercountQuarter.map(s=>(s._1,if(s._2 >9){"Qtr4"} else if(s._2>6 && s._2<=9){"Qtr3"} else if(s._2>3 && s._2<=6){"Qtr2"} else {"Qtr1"},s._3))


    val finalResult=ChecksubstringInQuarter.map(s=>(s._1,s._2,s._3))


    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("City",rdd._1).append("Quarter",rdd._2).append("Quantity",rdd._3))

       MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }
}
