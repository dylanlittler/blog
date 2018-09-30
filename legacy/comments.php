<?php

	// destroy session if user logs out; alternative function may be more appropriate
	if ($_POST['logout']) {
		unset($_SESSION['id']);
		// expire cookie
		setcookie("id", "", time() - 3600);
		$_COOKIE['id'] = "";
		header("Location: blogpost.php?id=".$_GET['id']."#date");
	// set session id to current cookie
	} else if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {
		$_SESSION['id'] = $_COOKIE['id'];
	}


	$session_details = "SELECT * FROM `users` WHERE `UserID` = '".$_SESSION['id']."' LIMIT 1";
	$result = $conn->query($session_details);
	$row = $result->fetch_assoc();
	$username = $row['UserName'];

	// insert comments as they are made on the post
	// comments are inserted to the database on this page and retrieved for display on blogpost.php
	if (isset($_POST['comment'])) {

		// only allow commenting if session id exists i.e. user is logged in
		if (array_key_exists("id", $_SESSION)) {

			// make username accessible to insert into new comment entry
			// prepare statement to secure against injection
			$stmt = $conn->prepare("INSERT INTO `comments` (`UserName`, `CommentText`, `BlogID`) VALUES (?, ?, ?)");
			$stmt->bind_param("ssi", $username, $comment, $blog_id);

			// username and comment must be displayed on the post they were written for
			$comment = $_POST['comment'];
			$blog_id = $_GET['id'];
			$stmt->execute();
			// refresh post variable to prevent duplicate comments from reloading
			header("Location: blogpost.php?id=".$_GET['id']."#date");			

			$stmt->close();

		} else {
			// user must login to post comments
			$error = "Please login or signup to comment.";
		}
	}
?>
