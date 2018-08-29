package FilterCustomerDetailsFilled

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object CustomerDetailsWiseSubCatWisePerformanceQtn {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(7)) getOrElse(""),Try(fields(13)) getOrElse(""),Try(fields(17)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.CustomerDetailsWiseSubCatWisePerformanceQtn")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.CustomerDetailsWiseSubCatWisePerformanceQtn")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()

    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty)


    //TotalFilter.foreach(println)

    val checkMobileNoYesOrNo = TotalFilter.map(s=>(s._2+"@"+s._3,s._1)).map(s=>(s._1,if(s._2.length == 12 || s._2.length==10 || s._2.length==11){1} else (0)))


    val toCheckCustomerMobileYesOrNo=checkMobileNoYesOrNo.map(s=>(s._1,if(s._2==1) {"Yes"} else ("No"))).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2)).map(s=>(s._3+"@"+s._1,s._2.toInt)).reduceByKey(_+_)

    //toCheckCustomerMobileYesOrNo.foreach(println)


    val finalResult=toCheckCustomerMobileYesOrNo.map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2))

    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    //  val df = new SimpleDateFormat("yyyy-MM-dd")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("CustomerMobile",rdd._1).append("SubCategory",rdd._2).append("Quantity",rdd._3))

     MongoSpark.save(sc.parallelize(newDocs))

     //  println(newDocs)

    })
  }




}