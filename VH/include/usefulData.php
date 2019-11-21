<?php
// Some useful data
echo "<font size=\"2\" color=\"gray\">\n";
//echo "<I>Server hostname: </I>" . $_SERVER['HTTP_HOST'] . " - ";
echo "<I>PHP server hostname: </I>" . gethostname() . " - ";
echo "<I>HTTP server local address: </I>" . $_SERVER['SERVER_ADDR'] . " - ";
echo "<I>Time of the request: </I>" . date("D M j G:i:s T Y", $_SERVER['REQUEST_TIME']) . "</ BR>";
echo "</font>\n";
?>
