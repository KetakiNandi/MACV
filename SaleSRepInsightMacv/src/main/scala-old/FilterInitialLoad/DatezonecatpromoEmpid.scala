package FilterInitialLoad

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DatezonecatpromoEmpid {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""),Try(fields(22)) getOrElse (""),Try(fields(8)) getOrElse (""),Try(fields(9)) getOrElse (""),
      Try(fields(12)) getOrElse (""),Try(fields(10)) getOrElse (""),Try(fields(11)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DatezonecatpromoEmpid")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DatezonecatpromoEmpid")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty && !s._6.isEmpty && !s._7.isEmpty)

    val Distinctdata= TotalFilter.map(s=>(s._1,s._2,s._3,s._4,s._5,s._6.replace("-",""),s._7)).distinct()


    val results = Distinctdata.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("Zone",rdd._2).append("SalesRepNameid",rdd._3).append("SalesRepName",rdd._4).append("Category",rdd._5).append("PromoNo",rdd._6).append("PromoName",rdd._7))

       MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)
    })
  }

}
