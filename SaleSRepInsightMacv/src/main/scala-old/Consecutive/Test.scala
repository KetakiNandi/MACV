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

import scala.util.Try

 object Test {

   def red(ABC:List[String]): List[String]={

    // print("FIRSTELEMENT",ABC)
     var finalList1 = scala.collection.mutable.ListBuffer[String]()
     var finalList = scala.collection.mutable.ListBuffer[String]("0")

     val format = new SimpleDateFormat("dd-MM-yyyy")

     val DDF ="dd-MM-yyyy"

     //var finallist1 = scala.collection.mutable.ListBuffer[String]()

    //println("dddddddddddd",ABC)

      if(ABC.size>2)
      {


        //finalList += ABC
         var firstDate1 = ABC(0).toString
        var firstDate = new DateTime(format.parse(firstDate1))

        //println("dddddddddddddddddddd",firstDate)

         for(i<-1 to ABC.size-1)
           {
             val count = 0;
             var nextDate1 = ABC.lift(i).get
             var nextDate = new DateTime(format.parse(nextDate1))

          // print("ssssssssssssssssssssssssssssss",nextDate.plusDays(0).toString(DDF))

           //  print("dddddddddddddddddddddddddddddd",firstDate.plusDays(1).toString(DDF))

            //04
             //

             if(firstDate.plusDays(1).toString(DDF).equals(nextDate.plusDays(0).toString(DDF)))
              {

             // println("%%%")
                if(i==1) {
                  finalList1 += nextDate.minusDays(1).toString(DDF)
                 // print("ssssssssssssssssssssssssssssss")
                }
               // if(i < 4)
                 // {



                    finalList1 +=nextDate.plusDays(0).toString(DDF)

                 // }

                 //i+1;


               firstDate = nextDate


               // print("ffffffffffffffffffff" ,firstDate)

              }



            else{

             }

             firstDate = nextDate
           }

        //finalList1 +=finalList1(0)

       { println(new DateTime(format.parse(finalList1.remove(0).toString())).minusDays(1).toString(DDF))}



        //println("&&&",new DateTime(format.parse(finalList1.take(1).toString())).minusDays(1).toString(DDF))
       }
     if(finalList1.size>1)

       {
         var sss = new DateTime(format.parse(finalList1.remove(0).toString())).minusDays(1).toString(DDF)
         finalList1 += sss
         return finalList1.toList
       }
     else{

       return finalList.toList
     }
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



    val SaleRepdata = sc.textFile("../SalesDetailstestP.csv")

    val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

    val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

    val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

    val mappedSaleRepdata = AccFilter.map(extractData)

    val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty  && !s._2.isEmpty  && !s._2.isEmpty)

    val checkyear17 = TotalFilter.map(s=>(s._1,s._2,s._3,s._4.toInt,s._5)).filter(s=>(s._4==0)).distinct()//.sortBy(x=>x._1,true,1)

    val convertDataframe = checkyear17.map(s=>(s._1,s._2))

    import org.apache.spark.sql.functions.unix_timestamp

    val ddd = spark.createDataFrame(convertDataframe).toDF("Date","ID")

    val aaa = ddd.select(ddd("Date"),ddd("ID")).sort(unix_timestamp(ddd("Date"),"dd-MM-yyyy")).rdd



   val finalResult =aaa.map(s=>(s.get(0),s.get(1))).map(s=>(s._2,s._1)).groupByKey()

    val listValuesort = finalResult.map(s=>(s._1,red(s._2.toList.asInstanceOf[List[(String)]])))//.collect()


    listValuesort.foreach(println)
   /* val RDDWithSessionStrtEndTimeSplitDate = listValuesort.map(x=>(x._1,x._2)).filter(s=>(s._2.nonEmpty)).map(s=>(s._1,s._2.toString.substring(5,s._2.toString().length-1))).map(s=>(s._1,s._2))


    val dfff =RDDWithSessionStrtEndTimeSplitDate.map(s=>(s._1,s._2.split(",")(0),s._2.split(",")(1),s._2.split(",")(2))).map(s=>(s._1,s._2.toString.substring(0,10),(s._3.toString.substring(0,11)).trim,(s._4.toString.substring(0,11)).trim))



//========//
    val joinformatcheckyear17 = checkyear17.map(s=>(s._2,s._3+"@"+s._5)).map(s=>(s._1.toString,s._2))

    val JoinTwoCollections = dfff.map(s=>(s._1,s._2+"@"+s._3+"@"+s._4)).map(s=>(s._1.toString,s._2))

    //val rdddss =joinformatcheckyear17.join(JoinTwoCollections)


    val fastCollectionCsv = spark.createDataFrame(joinformatcheckyear17).toDF("UserId","name")

    val secondCollection = spark.createDataFrame(JoinTwoCollections).toDF("UserId1","date")


    val dataframeCollections = fastCollectionCsv.join(secondCollection, fastCollectionCsv.col("UserId") === secondCollection.col("UserId1")).rdd//.show(1)


    val  dataframeCollectionsget = dataframeCollections.map(s=>(s.get(0),s.get(1),s.get(3))).distinct()

    val splitdataframeCollectionsget = dataframeCollectionsget.map(s=>(s._1,s._2.toString.split("@")(0),s._2.toString.split("@")(1),s._3.toString.split("@")(0),s._3.toString.split("@")(1),s._3.toString.split("@")(2)))


    val finalResult1 = splitdataframeCollectionsget.map(s=>(s._1,s._2,s._3,s._4,s._5,s._6))


    val results = finalResult1.collect()

    val today = Calendar.getInstance.getTime

    val df = new SimpleDateFormat("dd-MM-yyyy")

    results.foreach({ rdd =>

      val newDocs = Seq(new Document("TimeStamp",today).append("Fastdate",new Date(df.parse(rdd._4).getTime)).append("Secdate",new Date(df.parse(rdd._5).getTime)).append("thirddate",new Date(df.parse(rdd._6).getTime)).append("SalesRepNameid",rdd._1).append("SalesRepName",rdd._2).append("SourceSite",rdd._3))

     // MongoSpark.save(sc.parallelize(newDocs))
      println(newDocs)

    })*/
  }
}
