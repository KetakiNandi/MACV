package InitialLoad

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import InitialLoad.SalesPersonWiseUpSellingQtn.red
import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object SalesPerformanceValueASP {

def red(i: Int, i1: Int):Int=
{
  val z = i*i1
  return z
}



  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(18)) getOrElse(""),Try(fields(17)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.SalesPerformanceValueASP")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.SalesPerformanceValueASP")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()

    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty )

    val RemoveZeroInAmount =TotalFilter.map(s=>(s._1,s._2.toInt,s._3.toInt)).filter(s=>(s._2>0))

    val removeAmountValueZero = RemoveZeroInAmount.map(s=>(s._1,red(s._2,s._3))).reduceByKey(_+_)

    val AddQuantity =RemoveZeroInAmount.map(s=>(s._1,s._3.toInt)).reduceByKey(_+_)

    val joinTwocollections=removeAmountValueZero.join(AddQuantity).map(s=>(s._1,s._2._1,s._2._2)).collect()

    //joinTwocollections.foreach(println)
//    val a=joinTwocollections.map(s=>(s._1.substring(3,5).toInt,s._2,s._3)).filter(s=>(s._1==1))
//
//    val b =a.map(s=>(s._1.toString,s._2.toInt)).reduceByKey(_+_)
//
//    val dd=a.map(s=>(s._1,s._3.toInt)).reduceByKey(_+_)
//
//    dd.foreach(println)

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

        joinTwocollections.foreach({ rdd =>


          val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("Amount",rdd._2).append("CountPerday",rdd._3))

          MongoSpark.save(sc.parallelize(newDocs))

      //println(newDocs)

    })
  }

}
