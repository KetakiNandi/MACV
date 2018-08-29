package weekendDay

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.apache.spark.sql.functions.unix_timestamp
import org.bson.Document
import org.joda.time.format.DateTimeFormat

import scala.util.Try

object week {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(17)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.weekAndDayName")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.weekAndDayName")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty).map(s=>(s._1,s._1)).distinct().collect()


    val fmt = DateTimeFormat.forPattern("dd-MM-yyyy")


     val today = Calendar.getInstance.getTime

     val df = new SimpleDateFormat("dd-MM-yyyy")

    TotalFilter.foreach({ rdd =>

       val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("DayName",fmt.parseDateTime(rdd._2).toString("EEEEE")))

      MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

     })
  }

}