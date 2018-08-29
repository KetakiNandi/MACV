package FilterDateCityPosType

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateCityPosTypeWiseSRWiseContributionQtn {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")
    (Try(fields(5)) getOrElse(""),Try(fields(8)) getOrElse(""),Try(fields(9)) getOrElse(""),
      Try(fields(17)) getOrElse(""),Try(fields(29)) getOrElse(""),Try(fields(20)) getOrElse(""),Try(fields(1)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityPosTypeWiseSRWiseContributionQtn")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityPosTypeWiseSRWiseContributionQtn")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()

    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s => !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty && !s._6.isEmpty)

    val checkyear17 = TotalFilter.map(s => (s._1 + "@" + s._2 + "@" + s._3 + "@" + s._5 + "@" + s._6 +"@"+s._7, s._4.toInt)).filter(s => (s._2 != 0)).reduceByKey(_ + _) //.map(s=>(s._1,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._1.split("@")(3),s._1.split("@")(4),s._1.split("@")(5),s._1.split("@")(6)))


    val SalefinalResult = checkyear17.map(s => (s._1, s._2)).map(s => (s._1.split("@")(3), s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2), s._1.split("@")(4), s._1.split("@")(5), s._2))

    val results = SalefinalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp", today).append("date",new Date(df.parse(rdd._6).getTime)).append("PosType", rdd._1).append("City", rdd._5).append("SourceSite", rdd._2).append("SalespersonId", rdd._3).append("Salesperson", rdd._4).append("Quantity", rdd._7))

       MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }
}
