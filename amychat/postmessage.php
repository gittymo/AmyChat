<?php
	header("Cache-Control: no-cache, must-revalidate");
	 // Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	// Connect to the database server
	$dbconn = mysql_connect("rumpus", "mevanspn", "fee8f3ce56f015ba");
	if (!$dbconn) {
		die("Could not connect to server. " + mysql_error());
	}
	
	// Select the amychat database.
	$dbase = mysql_select_db("amychat");
	if (!$dbase) {
		die("Could not find database. " + mysql_error());
	}
	
	// Get the username, colour and message fields.
	$userName = $_GET["uname"];
	$colour = $_GET["col"];
	$message = $_GET["msg"];
	
	// Store the fields in the database
	$storeQuery = "INSERT INTO comments (userName,colour,comment) VALUES (\"" .
		$userName . "\"," . $colour . ", \"" . $message . "\")";
	$result = mysql_query($storeQuery);
	if (!$result) {
		die("SQL error: " . mysql_error());
	}
	
	// Close the database connection
	mysql_close($dbconn);
?>
