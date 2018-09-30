<?php

    // handle login
    if ($_POST['usernameLogin']) {

	$username = $_POST['usernameLogin'];		
	$password = $_POST['passwordLogin'];
	// ensure password is entered
	if ($_POST['passwordLogin'] == '') {
		$error = "Please enter your password";
	} else {

	    $user_exists = check($username);

	    if ($user_exists) {
		$row = $user_exists->fetch_assoc();

		// verify password entered by user
		if (password_verify($password, $row['UserPassword'])) {
		    // set user session, started in blogpost.php
		    $_SESSION['id'] = $row['UserID'];
		    // set cookie at user request; notice may be needed
		    if ($_POST['stayloggedin'] == 1) {
			setcookie("id", $row['UserID'], time() + 3600 * 24);
		    } else {
			setcookie("id", $row['UserID'], time() + 3600);
		    }

		    // redirect to blogpost if successful
		    header("Location: blogpost.php?id=".$_GET['id']."#date");
		    exit;
		} else {
		    $error = "Password or username is incorrect - please try again.";
		}

	    } else {
		$error = "Sorry, that username is not recognised. Do you wish to sign up?";
	    }
	}
    } else {
	$error = "Please enter your username and password";
    }

    // Sign up form handling
    if ($_POST['usernameSignup']) {

  	$username = $_POST['usernameSignup'];
	$password = $_POST['passwordSignup'];

	// user must enter password
	if ($password == '') {
	    $error = "Please enter a password for your new account.";
	} else {

	    $user_exists = check($username);

	    if ($user_exists->num_rows > 0) {
		$error = "Sorry, ".$username." is already taken. If you already have an account, please log in.";
	    } else {
		// prepared statement to safely add user
		$stmt = $conn->prepare("INSERT INTO `users` (`UserName`, `UserPassword`) VALUES (?, ?)");
		$stmt->bind_param("ss", $esc_username, $esc_password);
		$esc_username = $conn->real_escape_string($username);
		// hash new password
		$esc_password = $conn->real_escape_string(password_hash($password, PASSWORD_DEFAULT));
		if (!$stmt->execute()) {
		    $error = "An error occurred - please try again later.";
		} else {
		    // set new session for user
		    if ($_POST['stayloggedin'] == 1) {
			setcookie("id", $conn->insert_id, time() + 3600 *24);
		    } else {
			setcookie("id", $conn->insert_id, time() + 3600);
		    }
		    // redirect to original post
		    header("Location: blogpost.php?id=".$_GET['id']."#date");
		    exit;				
		    $stmt->close();
		}
	    }
	}
    }

    function check($username) {

	global $conn;

	$sql = "SELECT * FROM `users` WHERE `UserName` = '".$conn->real_escape_string($username)."' LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    return $result;
	} else {
	    return FALSE;
	}
    }

?>
