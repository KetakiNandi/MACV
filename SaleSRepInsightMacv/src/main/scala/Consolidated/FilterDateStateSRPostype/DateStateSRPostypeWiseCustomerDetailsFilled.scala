package Consolidated.FilterDateStateSRPostype

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateStateSRPostypeWiseCustomerDetailsFilled {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""),Try(fields(2)) getOrElse (""),Try(fields(7)) getOrElse (""),Try(fields(21)) getOrElse (""),
      Try(fields(29)) getOrElse (""),Try(fields(8)) getOrElse ("") ,Try(fields(9)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateStateSRPostypeWiseCustomerDetailsFilled")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateStateSRPostypeWiseCustomerDetailsFilled")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()


    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty && !s._6.isEmpty && !s._7.isEmpty     )

    val DistinctmappedSaleRepdata=TotalFilter.map(s=>(s._1+"#"+s._2+"#"+s._4+"#"+s._5+"#"+s._6+"#"+s._7,s._3)).distinct()//.count()


    val toCheckCustomerMobile = DistinctmappedSaleRepdata.map(s => (s._1,if(s._2.length == 12 || s._2.length==10 || s._2.length==11){1} else (0)))

    val toCheckCustomerMobileYesOrNo=toCheckCustomerMobile.map(s=>(s._1,if(s._2==1) {"Yes"} else ("No"))).map(s=>(s._1+"#"+s._2)).map(s=>(s,1)).reduceByKey(_+_)

    //toCheckCustomerMobileYesOrNo.foreach(println)

    val finalResult=toCheckCustomerMobileYesOrNo.map(s=>(s._1.split("#")(0),s._1.split("#")(2),s._1.split("#")(3),s._1.split("#")(4),s._1.split("#")(5),s._1.split("#")(6),s._2))

    // finalResult.foreach(println)

    val results = finalResult.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("State",rdd._2).append("PosType",rdd._3).append("SalesRepNameid",rdd._4).append("SalesRepName",rdd._5).append("CustomerMobile",rdd._6).append("Count",rdd._7))

      MongoSpark.save(sc.parallelize(newDocs))

      // println(newDocs)

    })
  }

}
