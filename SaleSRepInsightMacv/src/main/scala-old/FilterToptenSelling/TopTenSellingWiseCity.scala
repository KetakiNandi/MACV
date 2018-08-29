package FilterToptenSelling

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object TopTenSellingWiseCity {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(14)) getOrElse (""),Try(fields(20)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTenSellingWiseCity")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTenSellingWiseCity")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val checkyear17 = mappedSaleRepdata.map(s=>(s._1,s._2)).distinct()


    val results = checkyear17.collect()

    val today = Calendar.getInstance.getTime


    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("Item_Code",rdd._1).append("City",rdd._2))

       MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }

}
