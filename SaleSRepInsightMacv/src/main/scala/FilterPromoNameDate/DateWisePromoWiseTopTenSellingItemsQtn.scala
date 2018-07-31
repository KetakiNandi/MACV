package FilterPromoNameDate

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateWisePromoWiseTopTenSellingItemsQtn {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(13)) getOrElse(""),Try(fields(14)) getOrElse(""),Try(fields(16)) getOrElse(""), Try(fields(11)) getOrElse(""), Try(fields(10)) getOrElse(""), Try(fields(1)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWisePromoWiseTopTenSellingItemsQtn")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWisePromoWiseTopTenSellingItemsQtn")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty  && !s._5.isEmpty && !s._6.isEmpty)

 //  TotalFilter.foreach(println)

   val DownloaddataCount = TotalFilter.map(x => (x._6+"#"+x._4+"#"+x._1+"#"+x._3+"#"+x._2+"#"+x._5.replace("-",""))).map(s=>(s,1)).reduceByKey(_+_).sortBy(x=>x._2,false,1) //sort descending order


    //DownloaddataCount.foreach(println)

    val finalResult=DownloaddataCount.map(s=>(s._1.split("#")(0),s._1.split("#")(1),s._1.split("#")(2),s._1.split("#")(3),s._1.split("#")(4),s._1.split("#")(5),s._2))

    // finalResult.foreach(println)

    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

     val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("PromeName",rdd._2).append("PromeNo",rdd._6).append("SubCategory",rdd._3).append("Item_Code",rdd._5).append("Quantity",rdd._7))

        MongoSpark.save(sc.parallelize(newDocs))
      //println(newDocs)

    })
  }

}
