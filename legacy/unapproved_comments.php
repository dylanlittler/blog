<?php

	include 'connection.php';

	$sql = "SELECT * FROM `comments` WHERE `Approved` = 0";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		send_mail($result);
	}

	function send_mail($comment_array) {
		$to = "example@email.com";
		$subject = "Unapproved comments";

		$comments = "";
		while ($row = $comment_array->fetch_assoc()) {
			$comments .= '<p>'.$row['CommentText'].'</p>';
		}

		$message = "
		<html>
		<head>
		<title>These comments are waiting for approval</title>
		</head>
		<body>
		<p>These comments are waiting for approval:</p>".
		$comments.
		"</body>
		</html>
		";
	
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
		$headers .= 'From: <sitemaster@email.com>' . "\r\n";
	
		mail($to,$subject,$message,$headers);
	}
	
	$conn->close()

?> 
