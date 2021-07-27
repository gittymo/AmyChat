<?php
	header("Cache-Control: no-cache, must-revalidate");
	 // Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	
	$symbols = array(":)",";)","8o",":(",":D",":S","|)",":P","B(","XD","<B","{}");
	$images = array("smile","winking","surprise","sad","laugh","notsure","shifty",
		"rasp","thinking","lmao","love","egg");
	$colours = array("red","lime","blue","yellow","aqua","fuchsia","navy","purple",
		"maroon","green","olive","chocolate","deeppink","darkorange","dodgerblue",
		"gold","lightseagreen","firebrick","peachpuff","springgreen");
		
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
	
	// Get the userName from the request
	$userName = $_GET["uname"];
	
	if (strlen($userName) > 0) {
		// Check to see if the user is in the users table;
		$userQuery = "SELECT * FROM users WHERE userName='" . $userName . "'";
		$result = mysql_query($userQuery);
		if (!$result) {
			die("Failed to retrieve user data: " . mysql_error());
		}
		$isThere = mysql_num_rows($result);
		if ($isThere > 0) {
			$updateUserQuery = "UPDATE users SET lastRequest=UNIX_TIMESTAMP(now()) " .
				"WHERE userName = '" . $userName . "'";
			$result = mysql_query($updateUserQuery);
			if (!$result) {
				die("Failed to update user data: " . mysql_error());
			}
		} else {
			$addUserQuery = "INSERT INTO users VALUES(\"" . $userName . "\", " .
				"UNIX_TIMESTAMP(now()))";
			$result = mysql_query($addUserQuery);
			if (!$result) {
				die("Failed to add user data: " . mysql_error());
			}
		}
	}
	
	// Get the last 30 records from the database
	$fetchQuery = "SELECT * FROM comments ORDER BY id DESC LIMIT 20";
	$result = mysql_query($fetchQuery);
	if (!$result) {
		die("Could not get records. " + mysql_error());
	} else {
		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class=\"message\" style=\"border-color: " .
				$colours[$row["colour"]] . "\">";
			echo "<span class=\"userName\">" . $row["userName"] . ":</span>";
			$comment = nl2br($row["comment"]);
			for ($i = 0; $i < count($images); $i++) {
				$comment = str_replace($symbols[$i],"<img src=\"./" . $images[$i] .
					".png\"/>",$comment);
			}
			echo $comment . "</div>\n";
		}
	}
	
	// Close the database connection
	mysql_close($dbconn);
?>
