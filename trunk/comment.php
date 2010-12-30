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
$author = mysql_real_escape_string($xml->author);
$text = mysql_real_escape_string($xml->comment);
mysql_query("INSERT INTO comment(poll_id, user, UUID, text)
VALUES ('".$poll_id."', '".$author."', '".$_GET['pid']."', '".$text."')") or die('Query Failed');echo '<ResponseInfo ver="1" req="AddMCQuestionComment" statusCode="0" errorMsg="" />';
?>