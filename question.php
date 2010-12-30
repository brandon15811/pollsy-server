<?php
$con = mysql_connect("localhost","root","");
if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
if (!mysql_select_db("poll", $con))
	{
		die('<?xml version="1.0" encoding="utf-8"?><ResponseInfo ver="1" req="'.$method.'" statusCode="10" errorMsg="Error. Please Try Again"/>');
	} 

$sql = "SELECT poll_id FROM ap_settings
WHERE ID='1'";
$result = mysql_query($sql,$con);
if ($result)
	{
		$row = mysql_fetch_array($result);
		$poll_id = $row['0'];
	}
else
	{
		die('<?xml version="1.0" encoding="utf-8"?><ResponseInfo ver="1" req="'.$method.'" statusCode="10" errorMsg="Error. Please Try Again"/>');
	}

echo '<?xml version="1.0" encoding="utf-8"?><ResponseInfo ver="1" req="SubmitMCQuestion" statusCode="0" errorMsg=""><qid>'.$poll_id.'</qid></ResponseInfo>';
$xmlstr = $_POST['pollsydata'];

$xml = simplexml_load_string($xmlstr);
$title = $xml->title;
$choices = $xml->choice;
$method = $xml['req']; 
$etitle = mysql_real_escape_string($title);
mysql_query("INSERT INTO poll(poll_ID, question, votes, flag, user)
VALUES ('".$poll_id."', '".$etitle."', '0', '0', '".$_GET['pid']."')") or die('Query Failed');

foreach ($choices as $choice) {
	$num = 1;
	$echoice = mysql_real_escape_string($choice);
	mysql_query("INSERT INTO results(poll_ID, value, votes, answer_num)
	VALUES ('".$poll_id."', '".$echoice."', '0', '".$num."')") or die("Query Failed");
	$num = $num + 1;
}
$poll_id = $poll_id + 1;
$sql = "UPDATE ap_settings SET poll_id = '".$poll_id."'
WHERE ID = '1'";
if (mysql_query($sql,$con))
	{
		// echo "Success";
	}
else
	{
		die("Error: " . mysql_error());
	}
mysql_close($con);

?>