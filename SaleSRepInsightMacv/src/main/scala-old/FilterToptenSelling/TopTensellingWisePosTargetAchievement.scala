package FilterToptenSelling

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object TopTensellingWisePosTargetAchievement {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    //  val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(13)) getOrElse(""),Try(fields(14)) getOrElse(""),Try(fields(16)) getOrElse(""),
      Try(fields(5)) getOrElse ("") ,Try(fields(18)) getOrElse (""),Try(fields(27)) getOrElse (""))

  }


  ////date,Subcategory,ItemCode,stylecode,sourceSite,Amount,posTarget


  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTensellingWisePosTargetAchievement")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTensellingWisePosTargetAchievement")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty  && !s._6.isEmpty && !s._7.isEmpty)//date,


    val toptensellingData= TotalFilter.map(s=>(s._1+"@"+s._2+"@"+s._3+"@"+s._4+"@"+s._5,s._6.toInt,s._7)).filter(s=>(s._2!=0))


    //uniqueItemCode Count

    val DownloaddataCount = toptensellingData.map(x => (x._1)).map(s=>(s,1)).reduceByKey(_+_).sortBy(x=>x._2,false,1) //sort descending order

    // DownloaddataCount.take(10).foreach(println)

    // =====================================start sumamount value============================================//

    val SumAmountWithDate = toptensellingData.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_)

    val distinctPostarget= toptensellingData.map(s=>(s._1,s._3)).distinct()

    //==========JoinTwocollection And calculate postarget per amount


    val JoinTwocollection = distinctPostarget.join(SumAmountWithDate).map(s=>(s._1,s._2._1.toFloat,s._2._2.toFloat)).map(s=>(s._1,s._3*100/s._2))


    //JoinTwocollection.foreach(println)

    //=====================end================//

    // ========Join Twocollections===================

    val TolaJoinTwocollections = DownloaddataCount.join(JoinTwocollection).map(s=>(s._1,s._2._1,s._2._2))


    val finalResult=TolaJoinTwocollections.map(s=>(s._1.split("@")(2),s._1.split("@")(4),s._3))


    //finalResult.foreach(println)


    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("Item_Code",rdd._1).append("SourceSite",rdd._2).append("Actual",rdd._3))

       MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)


    })
  }

}
