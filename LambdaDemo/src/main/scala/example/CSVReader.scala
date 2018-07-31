package example

import com.amazonaws.services.s3.model.GetObjectRequest
import scala.io.Source
import com.amazonaws.services.s3.AmazonS3ClientBuilder
import org.apache.spark.SparkContext


object CSVReader {

  import com.amazonaws.auth.BasicAWSCredentials
  import com.amazonaws.services.s3.AmazonS3Client

  val s3Client = AmazonS3ClientBuilder.defaultClient();

  //import java.io.{InputStream, OutputStream, PrintStream}

  def reader() {

    //output.write("1111".getBytes("UTF-8"))

    val myMap = scala.collection.mutable.Map[String,String]()

    //println("111")

    //output.write("222".getBytes("UTF-8"))

    val s3Object = s3Client.getObject(new GetObjectRequest("macv", "Sales/SalesDetails18.csv"));

    //println("222")

    val myData = Source.fromInputStream(s3Object.getObjectContent()).getLines()

   // println("333")

    for (line <- myData) {
      val data = line.split(",")
      myMap.put(data(1), data(18))
    }

    println(" my map : " + myMap.toString())

    val sc = new SparkContext("local[*]", "Monetary")

    val AccFilter = myMap.filter(x => (!x._1.isEmpty && !x._2.isEmpty))

    val Frdd = sc.parallelize(AccFilter.toString()).collect()

    val Frdd1 = sc.parallelize(Frdd)

    val checkyear17 = Frdd1.map(s=>(s)).map(s=>(s.toString.split(",")(0),s.toString.split(",")(1)))

    val TotalFiltercount=checkyear17.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_)

    // TotalFiltercount.foreach(println)
    val finalResult=TotalFiltercount.map(s=>(s._1,s._2))
    val results = finalResult.collect()
  }

}
