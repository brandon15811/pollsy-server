<?php

	/*$xmlstr = '<?xml version="1.0" encoding="utf-8"?><RequestInfo ver="1" req="SubmitMCQuestion"><title>What do you think of this app?</title><choice>awesome</choice><choice>sucky</choice><group>0</group></RequestInfo>';*/
	$xmlstr = $_POST['pollsydata'];

$xml = simplexml_load_string($xmlstr);
$method = $xml['req']; 

switch ($method)
{
//Done(check for security)
	case "SubmitMCQuestion":
		include 'question.php';;
	break;
//Done(check for security)
	case "GetMCQuestionResults":
		include 'vote.php';
	break;
//Done(check for security)	
	case "SubmitMCResponse":
		include 'vote.php';
	break;
//Done(check for security)	
	case "GetNextMCQuestion":
		include 'poll.php';
	break;
	
/*	case "SearchGroups":
		include 'searchgroup.php';
	break;

	case "AddUserToGroup":
		include 'groupuser.php';
	break;

	case "CreateGroup":
		include 'creategroup.php';
	break;*/

	case "AddMCQuestionComment":
		include 'comment.php';
	break;
//Done(check for security)
	case "FlagMCQuestion":
		include 'flag.php';
	break;

	default:
		echo '<?xml version="1.0" encoding="utf-8"?><ResponseInfo ver="1" req="'.$method.'" statusCode="10" errorMsg="Feature Not Yet Implemented" />';
	break;
}

/*
<ResponseInfo ver="1" req="FlagMCQuestion" statusCode="0" errorMsg="" />

*/
?>