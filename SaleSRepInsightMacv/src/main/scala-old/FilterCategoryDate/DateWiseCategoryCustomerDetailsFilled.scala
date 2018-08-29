package FilterCategoryDate

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateWiseCategoryCustomerDetailsFilled {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""),Try(fields(2)) getOrElse (""),Try(fields(7)) getOrElse (""),Try(fields(12)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseCategoryCustomerDetailsFilled")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateWiseCategoryCustomerDetailsFilled")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)


    val checkyear17 = mappedSaleRepdata.map(s=>(s._1,s._1.toString.substring(6,10),s._2+"@"+s._3+"@"+s._4)).map(s=>(s._1+"@"+s._3,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._1.split("@")(2),s._1.split("@")(3)))

    //checkyear17.foreach(println)

    val DistinctmappedSaleRepdata=checkyear17.map(s=>(s._1+"@"+s._2+"@"+s._4,s._3)).distinct()//.count()

    //  print("ddddddddddddddddddd",DistinctmappedSaleRepdata.count())

    val toCheckCustomerMobile = DistinctmappedSaleRepdata.map(s => (s._1,if(s._2.length == 12 || s._2.length==10 || s._2.length==11){1} else (0)))//.count()

    //toCheckCustomerMobile.foreach(println)

    val toCheckCustomerMobileYesOrNo=toCheckCustomerMobile.map(s=>(s._1,if(s._2==1) {"Yes"} else ("No"))).map(s=>(s,1)).reduceByKey(_+_)


    val Result=toCheckCustomerMobileYesOrNo.map(s=>(s._1._1.split("@")(0),s._1._1.split("@")(2),s._1._2.split("@")(0),s._2)).map(s=>(s._1+"@"+s._2+"@"+s._3,s._4.toInt)).reduceByKey(_+_)

    //Result.foreach(println)

    val finalResult=Result.map(s=>(s._1,s._2)).map(x=>(x._1.split("@")(0),x._1.split("@")(1),x._1.split("@")(2),x._2))

    val finalresults = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    finalresults.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("Category",rdd._2).append("CustomerMobile",rdd._3).append("Count",rdd._4))

      MongoSpark.save(sc.parallelize(newDocs))

       //println(newDocs)

    })
  }

}
