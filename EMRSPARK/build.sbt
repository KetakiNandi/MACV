import sbt.Keys.libraryDependencies

//name := "LambdaDemo"

//version := "0.1"

//scalaVersion := "2.11.7"

javacOptions ++= Seq("-source", "1.8", "-target", "1.8", "-Xlint")



lazy val root = (project in file(".")).
  settings(

name := "EMRSPARK",
version := "0.1",
scalaVersion := "2.11.7",
retrieveManaged := true,
libraryDependencies += "com.amazonaws" % "aws-lambda-java-core" % "1.0.0",
libraryDependencies += "com.amazonaws" % "aws-lambda-java-events" % "1.0.0",
libraryDependencies += "com.fasterxml.jackson.module" % "jackson-module-scala_2.11" % "2.5.2",
libraryDependencies += "com.amazonaws" % "aws-java-sdk-s3" % "1.11.78",
//libraryDependencies +="org.mongodb.spark" %% "mongo-spark-connector" % "2.2.0",
libraryDependencies +="org.apache.spark" %% "spark-core" % "2.0.2",
libraryDependencies += "org.apache.spark" %% "spark-sql" % "2.2.0",
libraryDependencies +="joda-time" % "joda-time" % "2.9.9" ,
libraryDependencies += "net.liftweb" %% "lift-json" % "2.6",
libraryDependencies +="org.apache.hadoop" % "hadoop-hdfs" % "2.4.0"
)
assemblyMergeStrategy in assembly :=
  {
    case PathList("META-INF", xs @ _*) => MergeStrategy.discard
    case x => MergeStrategy.first
  }