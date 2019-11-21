<?php
function printInputHidden ($name,$action) {
  print "<input type=\"hidden\" name=\"$name\" value=\"$action\">\n";
}

function printStartForm () {
  //print "<form action=\"" . $_SERVER["SELF_PHP"] . "\" method=\"post\">\n";
  print "<form method=\"post\">\n";
}

function printEndForm () {
  $head_def = array("reset"=>"<input type=\"reset\">", "submit"=>"<input type=\"submit\" value=\"Submit\">");
  printTableHeader(array_flip($head_def));
  printTableEnd2();
  print "</form>\n";
}

function printTableHeader($head_arr) {
   print "<table border=\"0\" cellpadding=\"5\" cellspacing=\"1\">\n <tbody>\n";
   echo "   <thead>\n";
   echo "    <tr>\n";
   foreach (array_keys($head_arr) as $value) {
       print "       <th>" . $value . "</th>\n";
   }
   echo "    </tr>\n";
   echo "   </thead>\n";
}

function printTableRow ($row_arr,$content_arr) {
   echo "     <tr>\n";
   foreach (array_keys($row_arr) as $key) {
      if ( array_key_exists($key,$content_arr) ) { 
	      print "          <td>" . $content_arr[$key] . "</td>\n"; 
      } else { 
	      print "          <td></td>\n"; 
      }
   }
   print "     </tr>\n";
}

function  printTableEnd2() {
   echo "  </tbody>\n  </table>\n";
}
function  printTableEnd($end_arr) {
   echo "    <tr>\n";
   foreach ($end_arr as $key=>$value) {
	   print "      <td></td>\n";
   }
   echo "    </tr>\n";
   echo "  </tbody>\n  </table>\n";
}
?>
