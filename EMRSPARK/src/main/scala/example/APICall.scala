package example

import java.util.{ArrayList, Calendar}
import org.apache.http.{HttpStatus, NameValuePair}
import org.apache.http.client.entity.UrlEncodedFormEntity
import org.apache.http.client.methods.{CloseableHttpResponse, HttpPost}
import org.apache.http.impl.client.HttpClients
import org.apache.http.util.EntityUtils

object APICall {

  def APICallPart(nameValuePairs: ArrayList[NameValuePair]){

    //val url = "http://13.228.26.230:3000/SRInsightsP";

    val url = "http://localhost:3000/SRInsightsP";

    val post = new HttpPost(url)

    val httpClient = HttpClients.custom().build()

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
  }
}
