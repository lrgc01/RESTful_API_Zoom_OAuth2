<?php
// This is Grant Type Authorization_Code when we ask for a first authorization code, 
// send this code with the user credentials to obtain the first Access Token.

require_once("include/zoomConfigs.php");
//require_once("include/formFunctions.php");

/*
 * First, if Authorization code doesn't exist create one and get an Access Token 
 * for further operations.
 */

$access_token = $zoomConfigs["access_token"];
 if (!$access_token) {
   if ($_POST["authorization_code"]) {
	// Debug
	echo "Authorization code (POST) " . $_POST["authorization_code"] . "</BR>";
	$access_token = getAccessToken($_POST["authorization_code"]);
	echo "Access Token " . $access_token . "</BR>";
   } elseif ($_GET["code"]) {
	// Debug
	echo "Authorization code (GET) " . $_GET["code"] . "</BR>";
	$access_token = getAccessToken($_GET["code"]);
	echo "Access Token " . $access_token . "</BR>";
   } else {
	//	what to do if there's no authorization code
	getAuthorizationCode();
   }
 }

// Debug
//echo "Access Token " . $access_token . "</BR>";

/*
$display_settings["columns"] = $zoomConfig["meetings_column_entries"];
$display_settings["paging"] = $zoomConfig["meetings_paging_entries"];
$display_settings["type"] = "form";

$access_token = $zoomConfigs["access_token"];
$upcoming_meetings_url = zoomConfigs["upcoming_meetings_url"];
$json_resource = getZoomMeetings($access_token, $upcoming_meetings_url,null);
displayZoomMeetings($json_resource,$display_settings);

$get_meeting_url = zoomConfigs["get_meeting_url"];
$json_resource = getZoomMeetings($access_token, $get_meeting_url,"919112751");
//print "<p>list meetings output: " . var_dump($json_resource) . "</p>\n";
displayZoomMeetings($json_resource,$display_settings);
 */

/*
 * Create a meeting
 */
#$json_output = setZoomMeeting($access_token, $meetings_url);
#print "<p>set meetings output: " . var_dump($json_output) . "</p>\n";

/*
 * Delete a meeting given its ID
 */
//$meeting_id = "960614209";
//$json_output = delZoomMeeting($access_token, $delete_meeting_url, $meeting_id);
//var_dump($json_output);


/*
 * END of program
 */





/*
 * FUNCTIONS
 */

/* 1st step - simulate a request from a browser on the authorize_url 
 * will return an authorization code after the user is prompted for credentials
 */
function getAuthorizationCode() {
	global $zoomConfigs;
	$authorize_url = $zoomConfigs["authorize_url"];
	$client_id = $zoomConfigs["client_id"];
       	$callback_uri = $zoomConfigs["callback_uri"];

	// scope is optional
	//$authorization_redirect_url = $authorize_url . "?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $callback_uri . "&scope=zms:meeting:read";
	$authorization_redirect_url = $authorize_url . "?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $callback_uri;

	header("Location: " . $authorization_redirect_url);

	// Set a form if you don't want to redirect
	// echo "Go <a href='$authorization_redirect_url'>here</a>, copy the code, and paste it into the box below.<br /><form action=" . $_SERVER["PHP_SELF"] . " method = 'post'><input type='text' name='authorization_code' /><br /><input type='submit'></form>";
}

/* 
 * With the authorization code now gets the access token.
 */
function getAccessToken2() {
	global $zoomConfigs;
	$token_url = $zoomConfigs["token_url"];
	$client_id = $zoomConfigs["client_id"];
       	$client_secret = $zoomConfigs["client_secret"];

	$content = "grant_type=client_credentials";
	$authorization = base64_encode("$client_id:$client_secret");
	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $token_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$response = curl_exec($curl);
	curl_close($curl);

	if ($response === false) {
		echo "Failed";
		echo curl_error($curl);
		echo "Failed";
	} elseif (json_decode($response)->error) {
		echo "Error:<br />";
		echo $authorization_code;
		echo $response;
	}

	return json_decode($response)->access_token;
}

function getAccessToken($authorization_code) {
	global $zoomConfigs;
	$token_url = $zoomConfigs["token_url"];
	$client_id = $zoomConfigs["client_id"];
       	$client_secret = $zoomConfigs["client_secret"];
       	$callback_uri = $zoomConfigs["callback_uri"];

	$authorization = base64_encode("$client_id:$client_secret");
	$header = array("Authorization: Basic {$authorization}","Content-Type: application/x-www-form-urlencoded");
	$content = "grant_type=authorization_code&code=$authorization_code&redirect_uri=$callback_uri";

	// Debug
	//echo "In function getAccessToken Auth Code=" . $authorization_code . "</BR>";
	//echo "Content " . $content . "</br>";
	//echo "token_url " . $token_url . "</br>";

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $token_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $content
	));
	$json_response = curl_exec($curl);
	curl_close($curl);

	if ($response === false) {
		echo "Failed";
		echo curl_error($curl);
		echo "Failed";
	} elseif (json_decode($json_response)->error) {
		echo "Error:<br />";
		echo $authorization_code;
		echo $json_response;
	}

	return json_decode($json_response)->access_token;
}


/*
 * function getZoomMeetings
 * Given
 *   $access_token to access Zoom API
 *   $api_url = check on API reference Guide in Zoom: https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetings
 * Returns
 *   $json_response = HTTP response in JSON format
 */
function getZoomMeetings($access_token, $base_url, $meetingID) {
   // (the given base URL must be accordingly)
   if (is_null($meetingID)) {
      // List all meetings 
      $api_url = $base_url;
   } else { 
      // Get one specific meeting given its ID
      $api_url = $base_url . "/" . $meetingID;
   }

   $header = array("Authorization: Bearer {$access_token}");

   $curl = curl_init();
   curl_setopt_array($curl, array(
	CURLOPT_URL => $api_url,
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_RETURNTRANSFER => true
   ));
   $json_response = curl_exec($curl);
   curl_close($curl);

   return $json_response;
}


/*
 * function getZoomMeetings
 * Given
 *   $json_meetings = json formatted string of meetings (may be only one, of course)
 *   $type = form, raw, etc.
 * Returns
 *   none
 */
function displayZoomMeetings($json_meetings, $settings) {
  $coldef_arr = $settings["columns"];
  $pagdef_arr = $settings["paging"];
  $type = $settings["type"];

  $resource_obj = json_decode($json_meetings,true); // true = array, false = object
  $meetings = $resource_obj["meetings"];

  // Case where the query was to list all meetings
  if (!is_null($meetings)) {
     // Show each one of the meetings
     printTableHeader(array_flip($coldef_arr));
     foreach($meetings as $meeting_array) {
        printTableRow($coldef_arr,$meeting_array);
     }
     printTableEnd2();
     // Paging information
     printTableHeader(array_flip($pagdef_arr));
     printTableRow($pagdef_arr,$resource_obj);
     printTableEnd2();
     echo "\n<br>\n";
     // Case where the query was to list only one specific meeting by its ID
  } else {
     printTableHeader(array_flip($coldef_arr));
     printTableRow($coldef_arr,$resource_obj);
     printTableEnd2();
  }
}

/*
 * function setZoomMeeting
 * Given 
 *   $access_token to access Zoom API
 *   $api_url = check on API reference Guide in Zoom: https://marketplace.zoom.us/docs/api-reference/zoom-api/meetings/meetingdelete
 *   $meeting_def = assoc array with entries
 * Returns
 *   $json_response = HTTP response in JSON format
 */
function setZoomMeeting ($access_token, $api_url, $meeting_def) {

	$header = array("Authorization: Bearer {$access_token}","content-type: application/json");

	//$POSTFIELDS = json_encode($meeting_def);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $api_url,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($meeting_def)
	));
	$json_response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		  echo "cURL Error #:" . $err ." </br>\n";
	}

	//return json_encode($meeting_def);
	return $json_response;
}
function delZoomMeeting ($access_token, $api_url, $meeting_id) {

	$header = array("Authorization: Bearer {$access_token}");

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $api_url . "/" . $meeting_id,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => "DELETE"
	));
	$json_response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		  echo "cURL Error #:" . $err ." </br>\n";
	}

	//return json_encode($meeting_def);
	return $json_response;
}

?>
