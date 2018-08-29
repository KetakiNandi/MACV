package Consecutive

import java.sql.Date
import java.text.SimpleDateFormat
import java.util.Calendar

import com.mongodb.spark.MongoSpark
import org.antlr.v4.runtime.atn.SemanticContext.AND
import org.apache.spark.SparkContext
import org.apache.spark.sql.functions.monotonically_increasing_id
import org.apache.spark.sql.{SparkSession, functions}
import org.bson.Document
import org.joda.time.DateTime
import util.control.Breaks._


import scala.util.Try

 object Test {




   def red(ABC:List[String]): List[String]= {

     // print("FIRSTELEMENT",ABC)
     var finalList1 = scala.collection.mutable.ListBuffer[String]()
     var finalList = scala.collection.mutable.ListBuffer[String]("0")

     var finalList2 = scala.collection.mutable.ListBuffer[String]()


     val format = new SimpleDateFormat("mm-dd-yyyy")

     val DDF = "mm-dd-yyyy"


     if (ABC.size > 2) {

       var Datefrom = ABC.sorted //MM-dd-yyyy

     println("dddddddddddddddd",Datefrom)

    var x=0
     for (i <- 0 to Datefrom.size - 1) {

      var count=0

       var firstDate1 = Datefrom(i).toString
       var firstDate = new DateTime(format.parse(firstDate1))

       var p =1
       var x=0


       for (j<-i+1 to 2)
       {

         var nextDate1 = Datefrom(j).toString
        // var nextDate = new DateTime(format.parse(firstDate1))

        // println("ffffffffffff",nextDate1)

         if(firstDate.plusDays(i+p).toString(DDF).equals(nextDate1)){

         // println("gggggggggggggggggg",firstDate.plusDays(i).toString(DDF),firstDate.plusDays(i+p).toString(DDF))


           x=x+1
           p=p+1

         // println("xxxxxxxxxxxxxxx",x,"ppppppppppppppp",p)


         }

         else {

          // break()


         }


       }


       if(x==2){

         count=count+1

         finalList2+=firstDate.plusDays(i).toString(DDF)

        // println("COunt",count)
       }

     }


       }



    return finalList2.toList

   }








  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""), Try(fields(8)) getOrElse (""),Try(fields(9)) getOrElse (""), Try(fields(17)) getOrElse (""),Try(fields(5)) getOrElse (""))

  }

  /** Our main function where the action happens */
  def main(args: Array[String]) {

    val sc = new SparkContext("local[*]", "Monetary")

    val spark = SparkSession.builder()
      .master("local[*]")
      .appName("MongoSparkConnectorIntroCmd")
      .config("spark.mongodb.input.uri", "mongodb://127.0.0.1/SaleRepInsight.consecutive3DaySaleZero1")
      .config("spark.mongodb.output.uri", "mongodb://127.0.0.1/SaleRepInsight.consecutive3DaySaleZero1")
      .config("fs.hdfs.impl", classOf[org.apache.hadoop.hdfs.DistributedFileSystem].getName)
      .config("fs.file.impl", classOf[org.apache.hadoop.fs.LocalFileSystem].getName)
      .getOrCreate()



    val SaleRepdata = sc.textFile("../AAAAAA.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._2.isEmpty  && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._2,s._3,s._4.toInt,s._5)).filter(s=>(s._4==0)).distinct().sortBy(x=>x._1,true,1)

    val convertDataframe = checkyear17.map(s=>(s._1,s._2))

    import org.apache.spark.sql.functions.unix_timestamp

    val ddd = spark.createDataFrame(convertDataframe).toDF("Date","ID")

    val aaa = ddd.select(ddd("Date"),ddd("ID")).sort(unix_timestamp(ddd("Date"),"dd-MM-yyyy")).orderBy("Date").rdd//.show(55)


     val finalResult =aaa.map(s=>(s.get(0),s.get(1))).map(s=>(s._2,s._1)).distinct()//.groupByKey()

    //finalResult.foreach(println)


    val simpleDateFormat: SimpleDateFormat = new SimpleDateFormat("dd-mm-yyyy")
    val df = new SimpleDateFormat("mm-dd-yyyy")
    //println(df.format(date))

    val pp =finalResult.map(s=>(s._1,simpleDateFormat.parse(s._2.toString))).map(s=>(s._1,df.format(s._2))).groupByKey()

   //pp.foreach(println)

    val listValuesort = pp.map(s=>(s._1,red(s._2.toList.asInstanceOf[List[(String)]]))).collect()

   // listValuesort.foreach(println)

   val RDDWithSessionStrtEndTimeSplitDate = listValuesort.map(x=>(x._1,x._2)).filter(s=>(s._2.nonEmpty)).map(s=>(s._1,s._2.toString.substring(5,s._2.toString().length-1))).map(s=>(s._1.toString,s._2.toString))

   // RDDWithSessionStrtEndTimeSplitDate.foreach(println)




//========//
   val joinformatcheckyear17 = checkyear17.map(s=>(s._2,s._3+"@"+s._5)).map(s=>(s._1.toString,s._2.toString))

    import spark.implicits._

    val fastCollectionCsv = spark.createDataFrame(joinformatcheckyear17).toDF("UserId","name")//.show()

    val secondCollection = spark.createDataFrame(RDDWithSessionStrtEndTimeSplitDate).toDF("UserId1","date")//.show()

    val dataframeCollections = fastCollectionCsv.join(secondCollection, fastCollectionCsv.col("UserId") === secondCollection.col("UserId1")).rdd//.show()


    val  dataframeCollectionsget = dataframeCollections.map(s=>(s.get(0),s.get(1),s.get(3))).distinct()

   // dataframeCollectionsget.foreach(println)



    val splitdataframeCollectionsget = dataframeCollectionsget.map(s=>(s._1,s._2.toString.split("@")(0),s._2.toString.split("@")(1)))


    val finalResult1 = splitdataframeCollectionsget.map(s=>(s._1,s._2,s._3))


    val results = finalResult1.collect()

    val today = Calendar.getInstance.getTime

   // val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("SalesRepNameid",rdd._1).append("SalesRepName",rdd._2).append("SourceSite",rdd._3))

     MongoSpark.save(sc.parallelize(newDocs))
      //println(newDocs)

    })
  }
}
