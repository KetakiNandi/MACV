package FilterWeekendSalesQuarter

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import com.mongodb.spark.config.ReadConfig
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document
import com.mongodb.spark.sql._

import scala.util.Try

object DateWiseZoneWiseWeekendSalesMonthQuarter {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(17)) getOrElse(""),Try(fields(22)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseZoneWiseWeekendSalesMonthQuarter")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseZoneWiseWeekendSalesMonthQuarter")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val readConfig = ReadConfig(Map("uri" -> "mongodb://127.0.0.1/SaleRepInsight.weekAndDayName"))

    val Dff = spark.read.mongo(readConfig)



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty).map(s=>(s._1+"#"+s._3,s._2.toInt))

    val AddQuantity = TotalFilter.reduceByKey(_+_).map(s=>(s._1.split("#")(0),s._1.split("#")(1)+"#"+s._2))

    // AddQuantity.foreach(println)

    val DffwithDateUserId = Dff.select(Dff("date"), Dff("DayName")).rdd//.show(100)

    val substr = DffwithDateUserId.map(s=>(s.get(0).toString.substring(0,10),s.get(1))).map(s=>(s._1,if(s._2=="Sunday"){s._2} else if(s._2=="Saturday"){s._2} else if(s._2=="Friday"){s._2}else 0)).filter(s=>(s._2!=0))

    import java.text.SimpleDateFormat

    val inputFormat = new SimpleDateFormat("yyyy-MM-dd")
    val outputFormat = new SimpleDateFormat("dd-MM-yyyy")

    val formattedDate =substr.map(s=>(outputFormat.format(inputFormat.parse(s._1)),s._2)).map(s=>(s._1,s._2))

    // print("WWWWWWWWW",formattedDate.count())

    val dd = formattedDate.join(AddQuantity).map(s=>(s._1,s._2._1,s._2._2)).map(s=>(s._1.substring(3,5).toInt,s._3.split("#")(0),s._3.split("#")(1),s._1))

    val convertMonth =dd.map(s=>(if(s._1 > 9){"Qtr4"} else if(s._1 > 6 && s._1 <= 9){"Qtr3"} else if(s._1 > 3 && s._1 <=6){"Qtr2"} else {"Qtr1"},s._2,s._3,s._4))

    // convertMonth.foreach(println)
    val finalResult = convertMonth.map(s=>(s._1+"#"+s._2+"#"+s._4,s._3.toInt)).reduceByKey(_+_).map(s=>(s._1.split("#")(0),s._1.split("#")(1),s._2,s._1.split("#")(2)))

    //  finalResult.foreach(println)

    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._4).getTime)).append("Quarter",rdd._1).append("Zone",rdd._2).append("Quantity",rdd._3))

      MongoSpark.save(sc.parallelize(newDocs))

   //  println(newDocs)

    })
  }



}
