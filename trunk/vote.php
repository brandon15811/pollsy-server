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

/*$str = '<?xml version="1.0" encoding="utf-8"?><RequestInfo ver="1" req="SubmitMCResponse"><qid>4</qid><choice>2</choice><rating>0</rating></RequestInfo>';*/
$str = $_POST['pollsydata'];

$xml = simplexml_load_string($str);
$poll_id = $xml->qid; 
//echo $poll_id;
// Poll Table
$sql = "SELECT votes FROM poll
WHERE poll_ID='".$poll_id."'";
$result = mysql_query($sql,$con);
if ($result)
  {
  $row = mysql_fetch_array($result);
  $votes = $row['0'];
  }
else
  {
  die("Error: " . mysql_error());
  }
  $votes = $votes + 1;
$sql = "UPDATE poll SET votes = '".$votes."'
WHERE poll_ID = '".$poll_id."'";


if (mysql_query($sql,$con))
  {
  // echo "Success";
  }
else
  {
  die("Error: " . mysql_error());
  }

//Results Table
$answer_num = $xml->choice;
//echo $answer_num;
$sql = "SELECT votes FROM results
WHERE poll_ID='".$poll_id."' AND answer_num='".$answer_num."'";
$result = mysql_query($sql,$con);
if ($result)
  {
  $row = mysql_fetch_array($result);
  $votes = $row['0'];
  }
else
  {
  die("Error: " . mysql_error());
  }
  $votes = $votes + 1;
$sql = "UPDATE results SET votes = '".$votes."'
WHERE poll_ID = '".$poll_id."' AND answer_num='".$answer_num."'";


if (mysql_query($sql,$con))
  {
  //echo "Success";
  }
else
  {
  die("Error: " . mysql_error());
  } 
 
// XML
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<ResponseInfo ver="1" req="SubmitMCResponse" statusCode="0" errorMsg="">';
echo "<qid>".$poll_id."</qid>";
// Poll Table
$sql = "SELECT question FROM poll
WHERE poll_ID='".$poll_id."'";
$result = mysql_query($sql,$con);
if ($result)
  {
  $row = mysql_fetch_array($result);
  $title = $row['0'];
  echo "<title>".$title."</title>";
  }
else
  {
  die("Error: " . mysql_error());
  }
// Results Table 
$sql = "SELECT * FROM results
WHERE poll_ID='".$poll_id."'";
$result = mysql_query($sql,$con);
if ($result)
  {
  while($row = mysql_fetch_array($result))
  {
	echo "<choice count=\"".$row['votes']."\">";
	echo $row['value'];
	echo "</choice>";
  }
  
} else {
  die("Error: " . mysql_error());
  }

$sql = "SELECT * FROM comment
WHERE poll_ID='".$poll_id."'";
$result = mysql_query($sql,$con);
if ($result)
  {
  echo "<comments>";
  while($row = mysql_fetch_array($result))
  {
	echo "<comment author=\"".$row['user']."\">";
	echo $row['text'];
	echo "</comment>";
  }
  echo "</comments>";
  
} else {
  die("Error: " . mysql_error());
  }
echo "<ratings_pos>0</ratings_pos>";
echo "<ratings_neg>0</ratings_neg>";
echo "<user_answer>".$xml->choice."</user_answer>";
echo "</ResponseInfo>";
mysql_close($con);
?>