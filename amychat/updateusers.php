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
	
	// Get a list of all users connected within 30 seconds of this request.
	$nowLess10Seconds = time() - 10;
	$timeQuery = "SELECT userName FROM users WHERE lastRequest > " .
		$nowLess10Seconds;
	$result = mysql_query($timeQuery);
	if (!$result) {
		die("Failed to execute query: " . mysql_error());
	}
	
	// Get the number of results
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows == 0) {
		echo "No-one is online.";
	} else {
		for ($i = 0; $i < $num_rows; $i++) {
			$record = mysql_fetch_array($result, MYSQL_NUM);
			if ($record) {
				echo $record[0];
				if ($i < $num_rows - 1) {
					echo ", ";
				}
			}
		}
	}
	
	if ($num_rows > 0) {
		if ($num_rows > 1) {
			echo " are online.";
		} else {
			echo " is online.";
		}
	}
	
	// Close the database connection
	mysql_close($dbconn);
?>
