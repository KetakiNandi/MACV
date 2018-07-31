package Consecutive

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document
import org.joda.time.DateTime

import scala.util.Try

object consecutive3DaySaleZero {


//  def red(a:String,b:String,c:String):String={
//
//
//
//    return a
//  }





  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""), Try(fields(8)) getOrElse (""),Try(fields(9)) getOrElse (""), Try(fields(17)) getOrElse (""),Try(fields(5)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.consecutive3DaySaleZero")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.consecutive3DaySaleZero")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()





    val format = "yyyy-MM-dd"


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._2.isEmpty  && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._2,s._3,s._4.toInt,s._5)).filter(s=>(s._4==0)).distinct()//.sortBy(x=>x._1,true,1)

    val finalResult =checkyear17.map(s=>(s._1,s._2,s._3,s._5)).sortBy(x=>x._1,true,1)

    //checkyear17.foreach(println)

    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("SalesRepNameid",rdd._2).append("SalesRepName",rdd._3).append("SourceSite",rdd._4))

     MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }




}
