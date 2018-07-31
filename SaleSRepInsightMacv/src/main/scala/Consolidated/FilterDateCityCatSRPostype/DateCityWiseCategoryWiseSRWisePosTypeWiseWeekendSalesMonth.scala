package Consolidated.FilterDateCityCatSRPostype

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import com.mongodb.spark.config.ReadConfig
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document
import  com.mongodb.spark.sql._

import scala.util.Try

object DateCityWiseCategoryWiseSRWisePosTypeWiseWeekendSalesMonth {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(17)) getOrElse(""),Try(fields(20)) getOrElse("") ,Try(fields(12)) getOrElse(""),Try(fields(8)) getOrElse(""),Try(fields(9)) getOrElse(""),Try(fields(29)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityWiseCategoryWiseSRWisePosTypeWiseWeekendSalesMonth")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityWiseCategoryWiseSRWisePosTypeWiseWeekendSalesMonth")
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

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._3.isEmpty  && !s._4.isEmpty  && !s._5.isEmpty  && !s._6.isEmpty  && !s._7.isEmpty ).map(s=>(s._1+"#"+s._3+"#"+s._4+"#"+s._5+"#"+s._6+"#"+s._1.substring(3,5)+"#"+s._7,s._2.toInt))

    val AddQuantity = TotalFilter.reduceByKey(_+_).map(s=>(s._1.split("#")(0)+"#"+s._1.split("#")(1)+"#"+s._1.split("#")(2)+"#"+s._1.split("#")(3)+"#"+s._1.split("#")(4)+"#"+s._2+"#"+s._1.split("#")(6),s._1.split("#")(5).toInt)).map(s=>(s._2,s._1))

    val convertMonth =AddQuantity.map(s=>(if(s._1==1){"Jan"} else if(s._1==2){"Feb"} else if(s._1==3){"Mar"} else if(s._1==4){"Apr"} else if(s._1==5){"May"} else if(s._1==6){"Jun"} else if(s._1==7){"Jul"} else if(s._1==8){"Aug"} else if(s._1==9){"Sep"} else if(s._1==10){"Oct"} else if(s._1==11){"Nov"} else {"Dec"},s._2))

    val JoinFormat =convertMonth.map(s=>(s._2.split("#")(0),s._2.split("#")(1)+"#"+s._2.split("#")(2)+"#"+s._2.split("#")(3)+"#"+s._2.split("#")(4)+"#"+s._1+"#"+s._2.split("#")(5)+"#"+s._2.split("#")(6)))

    //JoinFormat.foreach(println)

    val DffwithDateUserId = Dff.select(Dff("date"), Dff("DayName")).rdd//.show(100)

    val substr = DffwithDateUserId.map(s=>(s.get(0).toString.substring(0,10),s.get(1))).map(s=>(s._1,if(s._2=="Sunday"){s._2} else if(s._2=="Saturday"){s._2} else if(s._2=="Friday"){s._2}else 0)).filter(s=>(s._2!=0))

    import java.text.SimpleDateFormat

    val inputFormat = new SimpleDateFormat("yyyy-MM-dd")
    val outputFormat = new SimpleDateFormat("dd-MM-yyyy")

    val formattedDate =substr.map(s=>(outputFormat.format(inputFormat.parse(s._1)),s._2)).map(s=>(s._1,s._2))

    val FinalResult = formattedDate.join(JoinFormat).map(s=>(s._1,s._2._1,s._2._2)).map(s=>(s._1,s._3.split("#")(0),s._3.split("#")(1),
      s._3.split("#")(2),s._3.split("#")(3),s._3.split("#")(4),s._3.split("#")(5),s._3.split("#")(6)))

    // FinalResult.foreach(println)
    val results = FinalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("Month",rdd._6).append("City",rdd._2).append("PosType",rdd._8).append("Category",rdd._3).append("SalesRepNameid",rdd._4).append("SalesRepName",rdd._5).append("Quantity",rdd._7))

      MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

    })
  }

}
