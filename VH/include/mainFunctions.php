<?php
function printPersonRights ($mysqli_conn,$person_info) {
  print "<p>Congrats! You are operating as a ";
  switch ($person_info["Role"]) {
     case "candidate":
	     print "<b>candidate</b>.</p>\n";
	     print "<p>Your rights:</p>\n";
	     if ($person_info["isPremium"]) {
		print "<blockquote>\n(You are Premium \n";
		if ($person_info["EnglishLevel"] != "") {
			print "and your English level is verified).</p>\n" .
			      "<p><b>You can attend to English Interview classes.</b></p>\n</blockquote>\n";
			displayDBMeetings($mysqli_conn,$person_info);
			printInputHidden("inputPersonId",$person_info["Id"]);
			printInputHidden("inputAction","selectMeeting");
			print "<p>Choose a meeting above and check below if you Will be actively participating:</p>\n";
			print "<input type=\"radio\" name=\"inputActive\" value=\"yes\" checked>yes \n";
			print "<input type=\"radio\" name=\"inputActive\" value=\"no\">no \n";
		} else {
			print "But your English level is not verified).</p>\n" .
			      "<p><b>You could attend to English Interview classes, but while trying to attend to a class you will receive an email notifying you to verify your English level</b>.</p>\n</blockquote>\n";
		}

	     } else {
		print "<blockquote>\n<p>(You are not Premium).</p>\n" .
		      "<p><b>You cannot attend to English Interview classes.</b></p>\n";
		if ($person_info["EnglishLevel"] != "") {
			print "<p>(But your English level is verified).</p>\n";
		} else {
			print "<p>(And you English level is not verified).</p>\n";
		}
		print "</blockquote>\n";
	     }
	 break;
     case "teacher":
	     print "<blockquote>\n";
	     print "<p><b>teacher</b>.</p>\n";
	     print "<p>You can create and present any English Interview classes in Zoom.</p>\n";
	     print "</blockquote>\n";
	     $person_info["EventAdmin"] = 1;
	     displayDBMeetings($mysqli_conn,$person_info);
	     printInputHidden("inputPersonId",$person_info["Id"]);
	     printInputHidden("inputAction","selectMeeting");
	 break;
     case "staff":
	     print "<blockquote>\n";
	     print "<b>staff</b> member.</p>\n";
	     print "<p><b>You can create and present any event in Zoom and attend to any English Interview class.</b></p>\n";
	     print "</blockquote>\n";
	     $person_info["EventAdmin"] = 1;
	     displayDBMeetings($mysqli_conn,$person_info);
	 break;
     default:
	     print "<blockquote>\n";
	     print "<p>member not defined.</p>\n";
	     print "</blockquote>\n";
	 break;
  }
}

function checkinMeeting ($mysqli_conn,$person_info) {
  switch ($person_info["Role"]) {
     case "candidate":
            displayDBMeetings($mysqli_conn,$person_info);
            checkinDBEvent($mysqli_conn,$person_info);
	    //printInputHidden("inputPersonId",$person_info["Id"]);
            //printInputHidden("inputAction","joinMeeting");
	 break;
     case "teacher":
     case "staff":
	    $person_info["EventAdmin"] = 1;
            displayDBMeetings($mysqli_conn,$person_info);
	    //printInputHidden("inputPersonId",$person_info["Id"]);
	    print "<p>Check the meeting and Submit to delete - or join as a Host or as a Member.</p>\n";
            printInputHidden("inputAction","deleteMeeting");
	 break;
     default:
	     print "<p>Error: Member not defined.</p>\n";
	 break;
  }
}
?>
