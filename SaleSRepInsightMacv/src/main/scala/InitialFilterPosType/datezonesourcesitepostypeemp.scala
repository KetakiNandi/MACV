package InitialFilterPosType

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object datezonesourcesitepostypeemp {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(22)) getOrElse(""),Try(fields(5)) getOrElse(""),Try(fields(29)) getOrElse(""),Try(fields(8)) getOrElse(""),Try(fields(9)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.datezonesourcesitepostypeemp")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.datezonesourcesitepostypeemp")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty  && !s._4.isEmpty  && !s._5.isEmpty  && !s._6.isEmpty)

    val dataDistinct = TotalFilter.map(s=>(s._1,s._2,s._3,s._4,s._5,s._6)).distinct()

    val results = dataDistinct.collect()

    val df = new SimpleDateFormat("dd-MM-yyyy")

    val today = Calendar.getInstance.getTime

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("Zone",rdd._2).append("SourceSite",rdd._3).append("PosType",rdd._4).append("SalesRepNameid",rdd._5).append("SalesRepName",rdd._6))

      MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }

}
