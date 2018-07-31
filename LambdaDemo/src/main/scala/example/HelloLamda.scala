package example

object HelloLamda {

  case class NameInfo(firstName: String, lastName: String)

  //def main(args: Array[String]): Unit = {
    import java.io.{InputStream, OutputStream, PrintStream}

    val scalaMapper = {
      import com.fasterxml.jackson.databind.ObjectMapper
      import com.fasterxml.jackson.module.scala.DefaultScalaModule
      new ObjectMapper().registerModule(new DefaultScalaModule)
    }

    def greeting(input: InputStream, output: OutputStream): Unit = {
      val name = scalaMapper.readValue(input, classOf[NameInfo])
      val result = s"Greetings ${name.firstName} ${name.lastName}."
      output.write(result.getBytes("UTF-8"))
    }
 // }

}
