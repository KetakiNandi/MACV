package FilterSubCategorywise

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object SubCategoryWiseSalesAVGQtnSoldPerDay {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(0)) getOrElse(""),Try(fields(5)) getOrElse(""),Try(fields(17)) getOrElse("") ,
      Try(fields(13)) getOrElse (""),Try(fields(1)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.SubCategoryWiseSalesAVGQtnSoldPerDay")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.SubCategoryWiseSalesAVGQtnSoldPerDay")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()

    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty)

    val initialMap=TotalFilter.map(s=>(s._4,s._2,s._1,s._3))


   // initialMap.foreach(println)
    val quantityCount=initialMap.map(s=>(s._1+"@"+s._2+"@"+s._3,s._4.toInt)).reduceByKey(_+_)//SubCategory,poscod,sourcesite,qtn

   val quantityCountSplit=quantityCount.map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._2))

    quantityCountSplit.foreach(println)
    val results = quantityCountSplit.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("yyyy-MM-dd")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("SubCategory",rdd._1).append("PosCode",rdd._3).append("SourceSite",rdd._2).append("Quantity",rdd._4))

      MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

    })
  }


}
