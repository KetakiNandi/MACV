package PosType

import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.apache.spark.SparkContext
import org.apache.spark.sql.SparkSession
import org.bson.Document

import scala.util.Try

object PosTypeWiseZoneWiseState {

  def PosMasterextractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(0)) getOrElse(""),Try(fields(13)) getOrElse(""))

  }

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(0)) getOrElse(""),Try(fields(22)) getOrElse(""),Try(fields(21)) getOrElse(""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.PosTypeWiseZoneWiseState")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.PosTypeWiseZoneWiseState")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val PosMasterSaleRepdata = sc.textFile("../PoS Master.csv")

    val Posheader = PosMasterSaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val PosMasterWithoutHeader = PosMasterSaleRepdata.filter(row => row != Posheader)

    val PosAccFilter = PosMasterWithoutHeader.filter(x => x!= "")

    val mappedposdata = PosAccFilter.map(PosMasterextractData)

    val notNullEmpty = mappedposdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

    val PosMaster = notNullEmpty.map(x => (x._1,x._2))  //posMaster Data

    val disPosMaster= PosMaster.map(s=>(s._1,s._2)).distinct()



    val SaleRepdata = sc.textFile("../SalesDetails17.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

    val DistinctZoneAndPosCode = TotalFilter.map(s=>(s._1,s._2,s._3)).distinct().map(s=>(s._1,s._2+"@"+s._3))

    //DistinctZoneAndPosCode.foreach(println)

   // println("ssssssssssssssssss",disPosMaster.count())

    val JoinTwoCollections = DistinctZoneAndPosCode.join(disPosMaster).map(s=>(s._2._1,s._2._2)).map(s=>(s._1.split("@")(0),s._1.split("@")(1),s._2))

   // JoinTwoCollections.foreach(println)

    val results = JoinTwoCollections.collect()

    val today = Calendar.getInstance.getTime

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("Zone",rdd._1).append("State",rdd._2).append("PosType",rdd._3))

       MongoSpark.save(sc.parallelize(newDocs))

     // println(newDocs)

    })
  }

}
