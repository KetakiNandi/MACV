package FilterToptenSelling

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object TopTensellingWiseSalesperformanceValue {


  def extractData(line: String)
  = {
    val fields = line.split(",")

  //  val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(13)) getOrElse(""),Try(fields(14)) getOrElse(""),Try(fields(16)) getOrElse(""),Try(fields(18)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTensellingWiseSalesperformanceValue")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.TopTensellingWiseSalesperformanceValue")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty)//date,

    val checkyear17 = TotalFilter.map(s=>(s._2+"@"+s._3+"@"+s._4+"@"+s._1,s._1.toString.substring(6,10))).map(s=>(s._1,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._1.split("@")(3)))

    //checkyear17.foreach(println)

    val DownloaddataCount = checkyear17.map(x => (x._1+"@"+x._2+"@"+x._3+"@"+x._4)).map(s=>(s,1)).reduceByKey(_+_).sortBy(x=>x._2,false,1) //sort descending order

   // DownloaddataCount.foreach(println)

    // =====================================start Salesperformance value============================================//

    val SumAmountWithDate = TotalFilter.map(s=>(s._2+"@"+s._3+"@"+s._4+"@"+s._1,s._5.toInt)).reduceByKey(_+_)



    //=====================end================//

    // ========Join Twocollections===================

    val JoinTwocollections = DownloaddataCount.join(SumAmountWithDate).map(s=>(s._1,s._2._1,s._2._2))

    val finalResult=JoinTwocollections.map(s=>(s._1.split("@")(1),s._1.split("@")(3),s._3)).filter(s=>(s._3!=0))


    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

     val df = new SimpleDateFormat("dd-MM-yyyy")

   results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._2).getTime)).append("Item_Code",rdd._1).append("Amount",rdd._3))

       MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }



}