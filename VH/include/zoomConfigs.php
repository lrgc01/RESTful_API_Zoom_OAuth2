<?php

$user_meetings_url    = "https://api.zoom.us/v2/users/me/meetings";
$specific_meeting_url = "https://api.zoom.us/v2/meetings";


$zoomConfigs = array (
"authorize_url" => "https://zoom.us/oauth/authorize",
"token_url" => "https://zoom.us/oauth/token",

"access_token" => "eyJhbGciOiJIUzUxMiJ9.eyJ2ZXIiOiI2IiwiY2xpZW50SWQiOiJuMEpIT0hicFQwQ3h3QjRMQ2Fvbnp3IiwiY29kZSI6Ing0M0NaanlrTUJfbWE4S3dPQXNUSnlRTUZIc3B6SGtxQSIsImlzcyI6InVybjp6b29tOmNvbm5lY3Q6Y2xpZW50aWQ6bjBKSE9IYnBUMEN4d0I0TENhb256dyIsImF1dGhlbnRpY2F0aW9uSWQiOiIzMjJkMGJjYWVhYjk1OWEwZmI1M2FlZjg0NGMyMjJlNSIsImVudiI6W251bGxdLCJ1c2VySWQiOiJtYThLd09Bc1RKeVFNRkhzcHpIa3FBIiwiZ3JvdXBOdW1iZXIiOjAsImF1ZCI6Imh0dHBzOi8vb2F1dGguem9vbS51cyIsImFjY291bnRJZCI6IlhRQjJXWGZvVDVTbHljT3daUXE2QkEiLCJuYmYiOjE1NzQyODgwMjEsImV4cCI6MTU3NDI5MTYyMSwidG9rZW5UeXBlIjoiYWNjZXNzX3Rva2VuIiwiaWF0IjoxNTc0Mjg4MDIxLCJqdGkiOiIwOWQwNjkzYi0yMDQyLTRiMjAtOTI5ZC00OTUyNzk5M2E3NDQiLCJ0b2xlcmFuY2VJZCI6MH0._qo_CyFp7WmpAFxN0voWNWALzRlevhPsG1FOC_C3hkFApRZ4zGBJMmEd_YBr92D9SCLn7qtc7-i09eVATggycA",

"client_id" => "n0JHOHbpT0CxwB4LCaonzw", 
"client_secret" => "ZdnkE0XNI1PAaTrM1HiRkGi2Gyf1OM8b",
"client_id_prod" => "OyuXd9fT8KzV4OmI0GISQ",
"client_secret_prod" => "iPznKyVdglRgkbHCkiwof5m2sb4o1irU",

//	callback URL specified when the application was defined--has to match what the application says
"callback_uri" => "https://lrgc01.uk.to" . $_SERVER["PHP_SELF"],

// Read Upcoming meetings / create meetings / etc.
// Always use 'me' in place of UserId when working with non admin applications at zoom
"user_meetings_url"    => $user_meetings_url,
"specific_meeting_url" => $specific_meeting_url,
"delete_meeting_url"   => $specific_meeting_url,
"get_meeting_url"      => $specific_meeting_url,
"upcoming_meetings_url" => $user_meetings_url . "?page_number=1&page_size=30&type=upcoming",

"meetings_paging_entries" => array("page_count" => "Total number of pages", 
	"page_number" => "Page number",
	"page_size" => "Total meetings per page",
	"total_records" => "Overall number of meetings"),

"meetings_column_entries" => array("id"=>"Id",
	"topic" => "Topic",
	"agenda" => "Description",
	"start_time" => "Start Time",
	"duration" => "Duration",
	"timezone" => "Timezone",
	"created_at" => "Creation date",
	"start_url" => "Host start URL",
	"join_url" => "URL to join",
	"password" => "Password"
        ),
// Definition of a meeting
"meeting_definition" => array(
   "topic" => "Test Meeting",
   "type" => "2",
   "start_time" => "2029-11-20T20:10:00",
   "duration" => 25,
   "timezone" => "UTC",
   "password" => "9012345687",
   "agenda" => "Description of Test meeting",
   "settings" => array(
         "host_video" => false,
         "participant_video" => false,
         "join_before_host" => false,
         "mute_upon_entry" => true,
         "approval_type" => 2,
         "audio" => "voip",
         "enforce_login" => false
	)
 )

);

?>
