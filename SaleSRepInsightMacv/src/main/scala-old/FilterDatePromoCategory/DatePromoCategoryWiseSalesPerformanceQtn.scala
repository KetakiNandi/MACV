package FilterDatePromoCategory

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DatePromoCategoryWiseSalesPerformanceQtn {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(11)) getOrElse (""), Try(fields(17)) getOrElse (""),Try(fields(1)) getOrElse (""),
      Try(fields(10)) getOrElse (""),Try(fields(12)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DatePromoCategoryWiseSalesPerformanceQtn")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DatePromoCategoryWiseSalesPerformanceQtn")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1+"#"+s._4.replace("-","")+"#"+s._3+"#"+s._5,s._2.toInt)).reduceByKey(_+_).map(s=>(s._1.split("#")(2),s._1.split("#")(0),s._1.split("#")(1),s._2,s._1.split("#")(3)))//date,zone,amount

    //checkyear17.foreach(println)

    val results = checkyear17.collect()

    val today = Calendar.getInstance.getTime
    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("PromoName",rdd._2).append("PromoNo",rdd._3).append("Count",rdd._4).append("Category",rdd._5))

      MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }




}
