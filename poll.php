<?php
$con = mysql_connect("localhost","root","");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db("poll", $con))
{
  die("Error: " . mysql_error());
} 
  function random_row($table) {
  $sql = "SELECT MAX(id) maxid FROM ".$table; 
  $id = mysql_fetch_object(mysql_query($sql)); 
  do { $rndid = rand(1, $id->maxid);
  $sql = "SELECT * FROM ".$table." WHERE id = ".$rndid; $rnd = mysql_fetch_object(mysql_query($sql));  } while (!$rnd);
  return $sql;
  }
  $sql = random_row('poll');
  $sql = mysql_query($sql, $con);
  $sql = mysql_fetch_array($sql);
  $poll_id = $sql['poll_ID'];
  $question = $sql['question'];
  echo '<?xml version="1.0" encoding="utf-8"?>';
  echo '<ResponseInfo ver="1" req="GetNextMCQuestion" statusCode="0" errorMsg="">';
  echo "<qid>".$poll_id."</qid>";
  echo "<title>".$question."</title>";
  $results = mysql_query("SELECT * FROM results
  WHERE poll_ID='".$poll_id."'");
  while($row = mysql_fetch_array($results))
  {
  echo "<choice>";
  echo $row['value'];
  echo "</choice>";
  }
  echo "</ResponseInfo>";
  /*echo "<br><br>";
  echo "<pre>";
  print_r($sql);
  echo "</pre>";*/
/*$sql = "SELECT poll_id FROM ap_polls
WHERE ID='1'";
$result = mysql_query($sql,$con);
if ($result)
  {
  $row = mysql_fetch_array($result);
  $id = $row['0'];
  }
else
  {
  die("Error: " . mysql_error());
  }
/*<ResponseInfo ver="1" req="GetNextMCQuestion" statusCode="0" errorMsg="">
	<qid>4009</qid>
	<title>Best 2pac song</title>
	<choice>changes</choice>
	<choice>hail mary</choice>
	<choice>all eyez on me</choice>
	<choice>keep ya head up</choice>
</ResponseInfo>*/
?>