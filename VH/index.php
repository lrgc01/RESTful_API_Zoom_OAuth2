<HTML>

<style type="text/css">table{
display: block;
overflow-x: auto;
word-wrap: break-word;
white-space: pre-wrap;
white-space: -moz-pre-wrap; 
white-space: -pre-wrap;
white-space: -o-pre-wrap;
width: 95%;
background-color: #eeeeee;
margin-left:auto; 
margin-right:auto;
}
</style>

<HEAD><TITLE>VanHackathon 2019 Test Suite</TITLE></HEAD>

<BODY>

<?php
require_once("include/inputFunctions.php");

// Check types with filter_input_array
// Use base function 'my_input_filter' to do some cleaning
$my_inputs     = filter_input_array(INPUT_POST, my_filter_args());
$inputEmail    = my_input_filter($my_inputs['inputEmail']);
$inputPersonId = my_input_filter($my_inputs['inputPersonId']);
$inputEventId  = my_input_filter($my_inputs['inputEventId']);
$inputAction   = my_input_filter($my_inputs['inputAction']);
$inputEventId  = my_input_filter($my_inputs['inputEventId']);
$inputActive   = my_input_filter($my_inputs['inputActive']);
//$delList       = $my_inputs['delList'];
?>

<H1 ALIGN="center">VanHackathon 2019</H1>

<H2 ALIGN="center">Test suite for an event schedule tool</H2>

<P>The main proposal is to create <b>English Interview Classes</b>, but may be used to whatever else with a few modifications.</P>
<P>For the sake of security some data may be repeatedly asked from time to time.</P>
<P>By this moment this is just a simulation, so simply choose one type of user to start scheduling or attending to meetings.</P>

<?php
require_once("include/formFunctions.php");
require_once("include/mainFunctions.php");
require_once("include/dbConfigs.php");
require_once("include/dbFunctions.php");
require_once("include/zoomFunctions.php");

$mysqli_conn = new mysqli(
	$dbConfigs["dbhost"], 
	$dbConfigs["dbuser"], 
	$dbConfigs["dbpass"], 
	$dbConfigs["dbname"]);

/*
 * Attention to the start of a form
 * All queries and screens will be within a form - no harm
 */
printStartForm();

if ( ($inputPersonId != NULL) or ($inputEmail != NULL) ) { 
  $person_info = getCandidate($mysqli_conn,$inputEmail,$inputPersonId);
 /*
  * Check which type of data is available and proceed accordingly
  * User may be selected either by email or id
  */
  switch ($inputAction) {
   case "userSelected":
     printPersonRights($mysqli_conn,$person_info);
   break;
   case "selectMeeting":
     if ($inputEventId) {
        $person_info["MeetingId"] = $inputEventId;
	if ($inputActive != NULL) {
           $person_info["Active"] = $inputActive;
	}
        checkinMeeting($mysqli_conn,$person_info);
     } else {
        printPersonRights($mysqli_conn,$person_info);
        //listPresentersCandidates($mysqli_conn);
        //printInputHidden("inputAction","userSelected");
     }
   break;
   case "deleteMeeting":
     if ($inputEventId) {
        $person_info["MeetingId"] = $inputEventId;
	if ($inputActive != NULL) {
           $person_info["Active"] = $inputActive;
	}
        deleteMeeting($mysqli_conn,$person_info);
     } else {
        printPersonRights($mysqli_conn,$person_info);
        //listPresentersCandidates($mysqli_conn);
        //printInputHidden("inputAction","userSelected");
     }
   break;
   default:
     // List of users and named variable in POST input
     listPresentersCandidates($mysqli_conn);
     printInputHidden("inputAction","userSelected");
   break;
 } // switch

} else {
   listPresentersCandidates($mysqli_conn);
   printInputHidden("inputAction","userSelected");
} // if


/*
$upcoming_meetings_url = $zoomConfigs["upcoming_meetings_url"];
$access_token = $zoomConfigs["access_token"];
$display_settings["columns"] = $zoomConfigs["meetings_column_entries"];
$display_settings["paging"] = $zoomConfigs["meetings_paging_entries"];
$display_settings["type"] = "form";
//$json_resource = getZoomMeetings($access_token, $upcoming_meetings_url,null);
$get_meeting_url = $zoomConfigs["get_meeting_url"];
$json_resource = getZoomMeetings($access_token, $get_meeting_url,"919112751");
print "<p>debug</p>" . var_dump($json_resource) . "<br>\n";
//displayZoomMeetings($json_resource,$display_settings);
*/


/*
 * Attention to the end of a form
 */
printEndForm();

$mysqli_conn->close();
// Just end with some data about the server
require_once("include/usefulData.php");
?>

</BODY>
</HTML>
