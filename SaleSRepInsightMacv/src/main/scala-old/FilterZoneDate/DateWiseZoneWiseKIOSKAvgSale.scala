package FilterZoneDate

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateWiseZoneWiseKIOSKAvgSale {

  def extractData(line: String)
  = {
    val fields = line.split(",")

   // val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(0)) getOrElse(""),Try(fields(1)) getOrElse(""),Try(fields(5)) getOrElse(""),Try(fields(22)) getOrElse(""),Try(fields(18)) getOrElse(0.0))//poscode,date,SSite,amount

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseZoneWiseKIOSKAvgSale")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseZoneWiseKIOSKAvgSale")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()

    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)


    val TotalFilter = mappedSaleRepdata.filter(s=> (!s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty ))

    val FilterAmount = TotalFilter.map(s=>(s._1,s._2,s._3,s._4,s._5.toString.toInt)).filter(s=>(s._5>0))

    val SumOfAmount = FilterAmount.map(x => (x._1+"@"+x._2+"@"+x._3+"@"+x._4,x._5.toString.toFloat)).reduceByKey(_+_).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._1.split("@")(3),s._2))

    val results = SumOfAmount.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._2).getTime)).append("PosCode",rdd._1).append("SourceSite",rdd._3).append("Zone",rdd._4).append("Amount",rdd._5))

      MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

    })
  }

}
