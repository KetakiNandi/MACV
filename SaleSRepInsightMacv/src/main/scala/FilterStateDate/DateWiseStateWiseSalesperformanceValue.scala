package FilterStateDate

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateWiseStateWiseSalesperformanceValue {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""),Try(fields(18)) getOrElse (""),Try(fields(21)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseStateWiseSalesperformanceValue")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseStateWiseSalesperformanceValue")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    //val SaleRepdata = sc.textFile("../SalesDetails17._18.csv")//Test 18Data




    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._1.toString.substring(6,10),s._2,s._3)).map(s=>(s._1+"@"+s._3+"@"+s._4,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2)))

    val TotalFiltercount=checkyear17.map(s=>(s._1+"@"+s._3,s._2.toInt)).reduceByKey(_+_)


//    //Test
//    val a =TotalFiltercount.map(s=>(s._1.split("@")(0).substring(3,5).toInt,s._1.split("@")(1),s._2.toInt)).filter(s=>(s._1==1))
//
//    val b =a.map(s=>(s._2,s._3)).filter(s=>(s._1=="Gujarat"))
//
//    val c =b.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_)
//
//    c.foreach(println)
//


    //TotalFiltercount.foreach(println)
    val finalResult=TotalFiltercount.map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2))
    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("State",rdd._2).append("Amount",rdd._3))

      MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }

}
