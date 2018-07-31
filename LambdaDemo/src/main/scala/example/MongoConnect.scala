package example

import java.io._
import java.sql.Date
import java.text.{DateFormat, SimpleDateFormat}
import java.time.{LocalDate, ZoneId}

import org.apache.commons._
import org.apache.http._
import org.apache.http.client._
import org.apache.http.client.methods.{CloseableHttpResponse, HttpPost}
import org.apache.http.impl.client.DefaultHttpClient
import java.util.{ArrayList, Calendar}

import org.apache.http.impl.client.{BasicCredentialsProvider, HttpClients}
import org.apache.http.message.BasicNameValuePair
import org.apache.http.client.entity.UrlEncodedFormEntity
import org.apache.http.util.EntityUtils
import org.apache.spark.SparkContext
import scala.util.Try


object MongoConnect {

  def extractData(line: String)
  = {
    val fields = line.split(",")

    val df = new SimpleDateFormat("dd-MMM-yy")

    (Try(fields(1)) getOrElse (""), Try(fields(18)) getOrElse (""))

  }

  //def readMongo(): Unit ={
  def main(args: Array[String]) {

      val url = "http://localhost:3000/SRInsightsP";

      val post = new HttpPost(url)

      // val client = new DefaultHttpClient
      val httpClient = HttpClients.custom().build()
      //val params = client.getParams
      //params.setParameter("foo", "bar")

      val sc = new SparkContext("local[*]", "Monetary")

      val SaleRepdata = sc.textFile("../SalesDetails18.csv")

      val header = SaleRepdata.first() //extract header.It will be removed during streaming(42 and 44 line)

      val SaleRepdataWithoutHeader = SaleRepdata.filter(row => row != header)

      val AccFilter = SaleRepdataWithoutHeader.filter(x => x != "")

      val mappedSaleRepdata = AccFilter.map(extractData)

      val TotalFilter = mappedSaleRepdata.filter(s=> !s._1.isEmpty && !s._2.isEmpty)

      val checkyear17 = TotalFilter.map(s=>(s._1,s._1.toString.substring(6,10),s._2)).map(s=>(s._1+"@"+s._3,if(s._2=="2016") {"0"} else ("1"))).filter(s=>(s._2!="0")).map(s=>(s._1.split("@")(0),s._1.split("@")(1)))

      val TotalFiltercount=checkyear17.map(s=>(s._1,s._2.toInt)).reduceByKey(_+_)

      // TotalFiltercount.foreach(println)
      val finalResult=TotalFiltercount.map(s=>(s._1,s._2))
      val results = finalResult.collect()
      //val input = new java.util.Date()

      //val today = input.toInstant().atZone(ZoneId.systemDefault()).toLocalDate();
      val today = Calendar.getInstance.getTime

      val df = new SimpleDateFormat("dd-MM-yyyy")

      results.foreach({ rdd =>

        val nameValuePairs = new ArrayList[NameValuePair]
        nameValuePairs.add(new BasicNameValuePair("TimeStamp",today.getTime.toString));
        nameValuePairs.add(new BasicNameValuePair("date", df.parse(rdd._1).getTime.toString));
        nameValuePairs.add(new BasicNameValuePair("Amount", rdd._2.toString));
        nameValuePairs.add(new BasicNameValuePair("ColName", "SalesperformanceValue"));
        post.setEntity(new UrlEncodedFormEntity(nameValuePairs));

        var response: CloseableHttpResponse = null
        try {

          response = httpClient.execute(post)
          println(s"response.setStatusCode: ${response.getStatusLine}")

          if (response.getStatusLine.getStatusCode == HttpStatus.SC_OK) {
            val entity = response.getEntity
            println(s"Response: ${EntityUtils.toString(entity)}")
            EntityUtils.consume(entity)
          }
        }
        catch {
          case e: Exception => println(e.getMessage)
        }
        finally {
          if (response != null)
            response.close()
        }

      })

  }

}
