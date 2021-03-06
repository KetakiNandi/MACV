package FilterDateSourceSiteCatPromo

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateSourceSiteCategoryPromoWisePoSTargetAchievement {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse ("") ,Try(fields(5)) getOrElse (""),Try(fields(12)) getOrElse (""), Try(fields(10)) getOrElse (""),
      Try(fields(11)) getOrElse (""), Try(fields(18)) getOrElse (""),Try(fields(27)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateSourceSiteCategoryPromoWisePoSTargetAchievement")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateSourceSiteCategoryPromoWisePoSTargetAchievement")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty  && !s._4.isEmpty  && !s._5.isEmpty  && !s._6.isEmpty  && !s._7.isEmpty )

    val replacebarline = TotalFilter.map(s=>(s._1+"#"+s._2+"#"+s._3+"#"+s._4.replace("-","")+"#"+s._5,s._6.toInt)).reduceByKey(_+_)//.filter(s=>(s._2!=0))


    val targetOfPos=TotalFilter.map(s=>(s._1+"#"+s._2+"#"+s._3+"#"+s._4.replace("-","")+"#"+s._5,s._7)).distinct()

    val JoinTwoCollections =  targetOfPos.join(replacebarline).map(s=>(s._1,s._2._1.toFloat,s._2._2.toFloat)) .map(s=>(s._1,s._3*100/s._2))

    val splitCollections=JoinTwoCollections.map(s=>(s._1.split("#")(0),s._1.split("#")(1),s._1.split("#")(2),s._1.split("#")(3),s._1.split("#")(4),s._2))

    //splitCollections.foreach(println)

    val results = splitCollections.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("SourceSite",rdd._2).append("Category",rdd._3).append("PromoNo",rdd._4).append("PromoName",rdd._5).append("Actual",rdd._6))

       MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }

}
