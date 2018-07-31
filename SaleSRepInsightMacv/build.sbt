name := "SaleSRepInsightMacv"

version := "0.1"

scalaVersion := "2.11.7"

libraryDependencies ++= Seq(
  "org.mongodb.spark" %% "mongo-spark-connector" % "2.2.0",
  "org.apache.spark" %% "spark-core" % "2.0.2" ,
  "org.apache.spark" %% "spark-sql" % "2.2.0" ,
  "joda-time" % "joda-time" % "2.9.9",
  "net.liftweb" %% "lift-json" % "2.6",
  "org.apache.hadoop" % "hadoop-hdfs" % "2.4.0"
)