<?php
	$conn = new mysqli("localhost", "username", "password", "db_name");

	if ($conn->connect_error) {
		die("Sorry, this page could not be found.");
	}
?>
