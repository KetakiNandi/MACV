package FilterQuarterValue

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object SalesperformanceValueQuarterWiseCustomerDetailsFilled {


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")


    (Try(fields(1)) getOrElse (""), Try(fields(18)) getOrElse (""), Try(fields(7)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.SalesperformanceValueQuarterWiseCustomerDetailsFilled")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.SalesperformanceValueQuarterWiseCustomerDetailsFilled")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty)


    val toCheckCustomerMobile = TotalFilter.map(s => (s._1+"@"+s._2,if(s._3.length == 12 || s._3.length==10 || s._3.length==11){1} else (0)))//.map(s=>(s._2+"@"+s._3+"@"+s._4+"@"+s._5,s._6))

    val toCheckCustomerMobileYesOrNo=toCheckCustomerMobile.map(s=>(s._1,if(s._2==1) {"Yes"} else ("No"))).map(s=>(s._1.split("@")(0),s._1.split("@")(1).toInt,s._2)).filter(s=>(s._2!=0))

    val convertquarterForm = toCheckCustomerMobileYesOrNo.map(s=>(s._1.toString.substring(3,5),s._2,s._3)).map(s=>(s._1.toInt,s._2,s._3)).map(s=>(s._3,if(s._1 >9){"Qtr4"} else if(s._1>6 && s._1<=9){"Qtr3"} else if(s._1>3 && s._1<=6){"Qtr2"} else {"Qtr1"},s._2))

    val conctquarterAndMobile=convertquarterForm.map(s=>(s._1+"@"+s._2,s._3.toInt)).reduceByKey(_+_).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2))


   // conctquarterAndMobile.foreach(println)

    val results = conctquarterAndMobile.collect()

     val today = Calendar.getInstance.getTime

     //  val df = new SimpleDateFormat("yyyy-MM-dd")

     results.foreach({ rdd =>

       val newDocs = Seq(new Document("TimeStamp",today).append("Quarter",rdd._2).append("CustomerMobile",rdd._1).append("Amount",rdd._3))

         MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

     })
  }
}
