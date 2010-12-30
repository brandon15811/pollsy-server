<?php
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
if (!mysql_select_db("cache", $con))
  {
  echo "Error selecting database: " . mysql_error()."<br>";
  }
/*$sql = "CREATE TABLE poll 
(
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
poll_ID int,
question varchar(105),
votes int,
flag int,
user varchar(50),
group_ID varchar(50),
misc varchar(50)
)";*/
/*$sql = "CREATE TABLE results 
(
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
poll_ID int,
value varchar(105),
votes int
)";*/
$sql = "CREATE TABLE popular 
(
ID int NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(ID),
type varchar(10),
json mediumtext,
time int
)";

if (mysql_query($sql,$con))
  {
  echo "Query completed<br>";
  }
else
  {
  echo "Error completing query: " . mysql_error()."<br>";
  }
mysql_close($con);
?>