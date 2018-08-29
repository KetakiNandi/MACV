package FilterCategoryDate

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateWiseCategoryWisePoSTargetAchievement {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(5)) getOrElse ("") ,Try(fields(18)) getOrElse (""),Try(fields(27)) getOrElse (""), Try(fields(1)) getOrElse (""), Try(fields(12)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseCategoryWisePoSTargetAchievement")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseCategoryWisePoSTargetAchievement")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty  && !s._4.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._2,s._3,s._4,s._5)).map(s=>(s._1+"@"+s._2+"@"+s._3+"@"+s._4+"@"+s._5,if(s._4.toString.substring(6,10)=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._1.split("@")(3),s._1.split("@")(4)))


    // checkyear17.foreach(println)

    val Addamountpos=checkyear17.map(s=>(s._1+"@"+s._4+"@"+s._5,s._2.toInt)).reduceByKey(_+_).filter(s=>(s._2!=0))//posname,Addmount

    // Addamountpos.foreach(println)

    val targetOfPos=checkyear17.map(s=>(s._1+"@"+s._4+"@"+s._5,s._3)).distinct()//distinctposname,target

    //targetOfPos.foreach(println)

    val joinTwoCollections=targetOfPos.join(Addamountpos).map(s=>(s._1,s._2._1.toFloat,s._2._2.toFloat)).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._3*100/s._2))

    //joinTwoCollections.foreach(println)

    val results = joinTwoCollections.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._2).getTime)).append("SourceSite",rdd._1).append("Actual",rdd._4).append("Category",rdd._3))

      MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }

}