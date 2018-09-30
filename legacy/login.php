<?php

	// start session to allow session variables for users
	session_start();

	// display error messages if login fails
	$error = "";

	include 'connection.php';

	// contains code for logging in and signing up
    include 'registration.php';

	$conn->close();

	// include header at end to allow redirecting after user has signed up or logged in
	include 'header.php';

	if ($_GET['action'] == 'login')	{
		$login_display = "block";
		$signup_display = "none";
	} else if ($_GET['action'] == 'signup') {
		$login_display = "none";
		$signup_display = "block";
	}

?>


<div class="container">
    <p>
	<a class="toggleForms" id="showLogInForm" href="#" onclick="return false;">Log In</a>
    </p>
    <p>
	<a class="toggleForms" id="showSignUpForm" href="#" onclick="return false;">Sign Up</a>
    </p>
    <div id="signupForm" style="display:<?php echo $signup_display; ?>">
	<form method="post">
	    <input type="text" name="usernameSignup" placeholder="Username">
	    <input type="password" name="passwordSignup" placeholder="Password">
	    <!-- value allows cookie to be created, otherwise user will be logged out straight away -->
	    <label for="stayLoggedin" class="stayLoggedin">Stay Logged In</label>
	    <input type="checkbox" name="stayloggedin" id="stayLoggedinSU" value="1">
	    <input type="Submit" value="Sign Up">
	</form>
    </div>

    <div id="loginForm" style="display:<?php echo $login_display; ?>">
	<form method="post">
	    <input type="text" name="usernameLogin" placeholder="Username">
	    <input type="password" name="passwordLogin" placeholder="Password">
	    <label for="stayLoggedin" class="stayLoggedin">Stay Logged In</label>
	    <input type="checkbox" name="stayloggedin" id="stayLoggedinLI" value="1">
	    <input type="submit" value="Log In">
	</form>
    </div>
    <!-- display errors here from sign up form -->
    <div>
	<p><?php echo $error; ?></p>
    </div>

    <!-- toggle display value of each form -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script type="text/javascript">

     $(".toggleForms").click(function() {

	 $("#signupForm").toggle();
	 $("#loginForm").toggle();

     });

    </script>
    <p class="page-nav"><a href=<?php echo "blogpost.php?id=".$_GET['id']; ?>>Back to post</a></p>
</div>
</body>
</html>
