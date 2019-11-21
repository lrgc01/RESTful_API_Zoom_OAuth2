<?php

/*
 * To all database functions here, the connection ($my_conn) must already exist
 */

// Read (SELECT only) functions

/*
 * function listCandidate
 * Given
 *   $my_conn = mysql connection already stablished
 *   $email = candidate email - if empty lists all candidates
 */
function listPresentersCandidates($my_conn) {
   $clause = "SELECT Person.Id as Id,FirstName,LastName,Email,Role,Company,'1' as isPremium,'Fluent' as EnglishLevel FROM Person,Presenter WHERE Person.Id=Presenter.Id UNION SELECT Person.Id,FirstName,LastName,Email,Role, 'N/A' as Company,isPremium,EnglishLevel FROM Person,Candidate WHERE Person.Id=Candidate.Id";
   $sel_stmt = $my_conn->prepare($clause);
   $sel_stmt->execute(); 

   $result = $sel_stmt->get_result(); 

   // Fetch each row which is an Associative Array
   $row = $result->fetch_assoc();
   if ($row) {
      printTableHeader($row);
      while ($row)
      {   
	 // Change Id number into a radio input
	 $row["Id"] = "<input type=\"radio\" name=\"inputPersonId\" value=\"" . $row["Id"] . "\">";
	 ( $row["isPremium"] > 0 ? $row["isPremium"] = "yes" : $row["isPremium"] = "no" );
	 ( $row["EnglishLevel"] != '' ? : $row["EnglishLevel"] = "Not Informed");
         printTableRow ($row,$row);
         $row = $result->fetch_assoc();
      }
      printTableEnd2();
   }
}


/* 
 * function checkCandidateToClass
 * Given
 *   $my_conn = mysql connection already stablished
 *   $email = candidate email not null
 * Return
 *   associative array of 2 keys: Premium=>(boolean), EnglishChecked=>(boolean)
 */
function checkinDBEvent ($my_conn, $person_info) {
   $AttendeeId = $person_info["Id"];
   $MeetingId  = $person_info["MeetingId"];
   if ($person_info["Active"] == "yes") {
      $isActive = "1";
   } else {
      $isActive = "0";
   }
   
   $clause = "INSERT INTO EventAttendee (EventId, AttendeeId, isActive) SELECT Id as EventId, '" . $AttendeeId . "' as AttendeeId, '" . $isActive . "' as isActive FROM Event WHERE MeetingId='" . $MeetingId . "'" ;
   print "<p>Debug: clause = $clause</p>\n";
   $sel_stmt = $my_conn->prepare($clause);
   $sel_stmt->execute(); 

   //$result = $sel_stmt->get_result(); 

}

/*
 * function getCandidate
 * Given
 *   $my_conn = mysql connection already stablished
 *   $email = candidate email - if empty lists all candidates
 */
function getCandidate($my_conn,$email,$id) {
   if ($email != NULL) {
      $clause = "SELECT Person.Id as Id,FirstName,LastName,Email,Role,Company,'1' as isPremium,'Fluent' as EnglishLevel FROM Person,Presenter WHERE Person.Id=Presenter.Id and Email='" . $email . "' UNION SELECT Person.Id,FirstName,LastName,Email,Role, 'N/A' as Company,isPremium,EnglishLevel FROM Person,Candidate WHERE Person.Id=Candidate.Id and Email='" . $email . "' ";
   } elseif ($id != NULL) {
       $clause = "SELECT Person.Id as Id,FirstName,LastName,Email,Role,Company,'1' as isPremium,'Fluent' as EnglishLevel FROM Person,Presenter WHERE Person.Id=Presenter.Id and Person.Id='" . $id . "' UNION SELECT Person.Id,FirstName,LastName,Email,Role, 'N/A' as Company,isPremium,EnglishLevel FROM Person,Candidate WHERE Person.Id=Candidate.Id and Person.Id='" . $id . "' ";
   }
   $sel_stmt = $my_conn->prepare($clause);
   $sel_stmt->execute(); 

   $result = $sel_stmt->get_result(); 

   return $result->fetch_assoc();
}

/*
 * function getDBMeetings
 * Given
 *   $my_conn = mysql connection already stablished
 *   $settings = array of settings containing email, id, isPremium and EnglishLevel (see getCandidate function return)
 * Returns:
 *   $result = result object of the SELECT statement (0->many rows)
 */
function getDBMeetings($my_conn,$settings) {
   if (array_key_exists("Email",$settings) ) {
      $email=$settings["Email"];
   }
   if (array_key_exists("Id",$settings) ) {
      $id=$settings["Id"];
   }
   $isPremium=$settings["isPremium"];
   $EnglishLevel=$settings["EnglishLevel"];

   if ( ($isPremium) and ($EnglishLevel != '') ) {
       $clause = "SELECT MeetingId,Title,StartDate,RoomLink,StartUrl,CreatorId,SpanTime FROM Event";
   } else { 
       $clause = "SELECT Title,StartDate,CreatorId,SpanTime FROM Event";
   }
   if (array_key_exists("MeetingId",$settings) ) {
       $clause = $clause . " WHERE MeetingId='" . $settings["MeetingId"] . "'";
   }
	
   $sel_stmt = $my_conn->prepare($clause);
   $sel_stmt->execute(); 

   $result = $sel_stmt->get_result(); 

   return $result;
}

function displayDBMeetings($my_conn,$settings) {
   $query_output = getDBMeetings($my_conn,$settings);
   if (array_key_exists("EventAdmin",$settings) ) {
      $EventAdmin = 1;
   } else { $EventAdmin = 0; }

   // Fetch each row which is an Associative Array
   $row = $query_output->fetch_assoc();

   // Special case in which the Meeting was chosen
   if (array_key_exists("Active",$settings) ) {
      $row["Active"] = $settings["Active"];
      $row["Join Link"] = $row["RoomLink"];
   }

   // If not an event admin (teacher or staff), returns no StartUrl and no RoomLink
   if (!$EventAdmin) {
      $row = array_diff_key($row,array("StartUrl"=>"N/A","RoomLink"=>"N/A"));
   }

   // Start table output
   if ($row) {
      printTableHeader($row);
      while ($row)
      {   
	      /*
         if (array_key_exists("Active",$settings) ) {
            $row["Active"] = $settings["Active"];
            $row["Join Link"] = $row["RoomLink"];
         }
	       */
         // If not an event admin (teacher or staff), returns no StartUrl and no RoomLink

         if (!$EventAdmin) {
            $row = array_diff_key($row,array("StartUrl"=>"N/A","RoomLink"=>"N/A"));
	 }
	 $row["MeetingId"] = "<input type=\"radio\" name=\"inputEventId\" value=\"" . $row["MeetingId"] . "\">";

	 // Change RoomLink url into a href link
	 if (array_key_exists("RoomLink",$row) ) {
	    $row["RoomLink"] = "<a href=\"" . $row["RoomLink"] . "\" target=\"_blank\">Room Link</a>";
	 }
	 if (array_key_exists("StartUrl",$row) ) {
	    $row["StartUrl"] = "<a href=\"" . $row["StartUrl"] . "\" target=\"_blank\">Host Link</a>";
	 }
	 if (array_key_exists("Join Link",$row) ) {
	    $row["Join Link"] = "<a href=\"" . $row["Join Link"] . "\" target=\"_blank\">Host Link</a>";
	 }
         printTableRow ($row,$row);
         $row = $query_output->fetch_assoc();
      }
      printTableEnd2();
   }

}

function data_to_delete($my_conn,$delList)
{
	if ($delList != NULL) {
	   $OR_clause = "DELETE FROM mainData WHERE id=" . my_input_filter($delList[0]);
	   for ($i = 1 ; $i < sizeof($delList) ; $i++) {
		$id = my_input_filter($delList[$i]);
		$OR_clause = $OR_clause . " or id=" . $id;
	   }
	   //print "<p> " . $OR_clause . "</p>\n";
           $delete_stmt = $my_conn->prepare($OR_clause);
           $delete_stmt->execute(); // Execute the statement.
	}
}

