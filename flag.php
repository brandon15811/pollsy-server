<?php
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
if (!mysql_select_db("poll", $con))
  {
  echo "Error selecting database: " . mysql_error()."<br>";
  }
$str = $_POST['pollsydata'];  

$xml = simplexml_load_string($str);
$poll_id = $xml->qid; 
//echo $poll_id;
// Poll Table
$sql = "SELECT flag FROM poll
WHERE poll_ID='".$poll_id."'";
$result = mysql_query($sql,$con);
if ($result)
{
  $row = mysql_fetch_array($result);
  $flag = $row['0'];
  }
else
  {
  die("Error: " . mysql_error());
  }
  $flag = $flag + 1;
$sql = "UPDATE poll SET flag = '".$flag."'
WHERE poll_ID = '".$poll_id."'";


if (mysql_query($sql,$con))
  {
  // echo "Success";
  }
else
  {
  die("Error: " . mysql_error());
  }
echo '<ResponseInfo ver="1" req="FlagMCQuestion" statusCode="0" errorMsg="" />'
  
?>