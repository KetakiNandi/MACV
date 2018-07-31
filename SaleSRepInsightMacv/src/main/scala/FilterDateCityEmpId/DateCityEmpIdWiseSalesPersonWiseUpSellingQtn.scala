package FilterDateCityEmpId

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object DateCityEmpIdWiseSalesPersonWiseUpSellingQtn {

  def red(a:Int):Int={
    val b=1
    val z=a-b
    return z
  }


  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse(""),Try(fields(2)) getOrElse(""),Try(fields(5)) getOrElse(""),
      Try(fields(6)) getOrElse(""),Try(fields(14)) getOrElse("") ,Try(fields(8)) getOrElse(""),Try(fields(9)) getOrElse(""),Try(fields(20)) getOrElse(""),Try(fields(18)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityEmpIdWiseSalesPersonWiseUpSellingQtn")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.DateCityEmpIdWiseSalesPersonWiseUpSellingQtn")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x!= "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty && !s._3.isEmpty && !s._4.isEmpty && !s._5.isEmpty  && !s._6.isEmpty && !s._7.isEmpty && !s._8.isEmpty && !s._9.isEmpty)

    val a=TotalFilter.map(s=>(s._1,s._2,s._3,s._4,s._5,s._6,s._7,s._8,s._9.toInt)).filter(s=>(s._9>0))//date,billNo,sourceSite,customername,itemCode,empId,empName

    val distinctDateAndBillNo=a.map(s=>(s._1,s._2,s._4,s._5,s._8)).distinct().map(s=>(s._1+"@"+s._2+"@"+s._3+"@"+s._5,if(s._4.toString.length >=1){1} else 0))

    //date,billno,customerName,itemCount

    val AddItemcodevalue=distinctDateAndBillNo.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_).map(s=>(s._1,red(s._2))).filter(s=>(s._2!=0)).map(s=>(s._1.split("@")(0)+"#"+s._1.split("@")(1)+"#"+s._1.split("@")(2)+"#"+s._1.split("@")(3),s._2))

    // AddItemcodevalue.foreach(println)

    val SourceSiteAndEmp = a.map(s=>(s._1,s._2,s._4,s._3,s._6,s._7,s._8)).distinct().map(s=>(s._1+"#"+s._2+"#"+s._3+"#"+s._7,s._4+"#"+s._5+"#"+s._6+"#"+s._7))

    // SourceSiteAndEmp.foreach(println)

    val b = AddItemcodevalue.join(SourceSiteAndEmp).map(s=>(s._1,s._2._1,s._2._2))

    // b.foreach(println)

    val splitvalue = b.map(s=>(s._1.split("#")(0),s._2,s._3.split("#")(0),s._3.split("#")(1),s._3.split("#")(2),s._3.split("#")(3))).collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    splitvalue.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("date",new Date(df.parse(rdd._1).getTime)).append("UniqueItemCodeCount",rdd._2).append("SourceSite",rdd._3).append("City",rdd._6).append("SalespersonId",rdd._4).append("Salesperson",rdd._5))

       MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }

}
