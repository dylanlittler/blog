<?php

	session_start();

	include 'connection.php';
    
	// include error messages to be displayed in comment form
	$error = "";
	
	// include code for comments box
    include 'comments.php';

    // retrieve id for post from URL
    if(isset($_GET['id'])){
    	$blog_id = $_GET['id'];
    }

	// create url and send id to that page, so that users can return
	// to the page they were on
	$url = 'login.php?id='.$_GET['id'];

	// retrieve comments made on this page
	$get_comments = "SELECT DISTINCT `CommentText`, `UserName` FROM `comments` WHERE `BlogID` = '".$_GET['id']."' AND Approved = 1 ORDER BY `CreatedDate` DESC";

	$comments = $conn->query($get_comments);

	// select post from database matching id passed from get request
    $post = "SELECT title, blog_text, DATE_FORMAT(created_date, \"%d %M %Y\")AS date FROM blogs WHERE blog_id = '$blog_id' LIMIT 1";

    $result = $conn->query($post);
    $row = $result->fetch_assoc();

	// set page title, include header here, to prevent interference with redirects to reset post request, display post
    if($result->num_rows > 0){
		$title = 'Coding Linguist - ' . $row['title'];
		include 'header.php';
		printf("<h1>%s</h1>\n", $row["title"]);
    	printf("%s\n", $row["blog_text"]);
		printf("<p id='date'>%s</p>\n", $row["date"]);

	// redirect to blog home if post could not be retrieved
    } else {
    	header("Location: bloghome.php");
    }

	$conn->close();
	if (isset($username)) {
		$message = "Welcome, ".$username;
		$logout_display = "block";
		$login_display = "none";
	} else {
		$message = "Please login or signup to comment.";
		$logout_display = "none";
		$login_display = "block";
	}

?>
<!-- comment form here -->
<form method="post" id="comments">
<p id="user-status"><?php echo $message; ?></p>
<div style="display:<?php echo $login_display; ?>">
<div class="page-nav"><p><a href="<?php echo $url; ?>&action=login">Login</a></p></div>
<div class="page-nav"><p><a href="<?php echo $url; ?>&action=signup">Sign Up</a></p></div>
</div>
<div id="comments-form" style="display:<?php echo $logout_display; ?>">
<textarea id="comment" name="comment"></textarea>
<input type="submit" name="logout" value="Log Out">
<input type="submit" value="Comment">
</div>
<!-- display any errors with posting comments here -->
<div><p><?php echo $error; ?></p></div>
</form>

<?php

	// display all comments here
	while ($new_comment = $comments->fetch_assoc()) {
		printf('<div><p>%s<br>', $new_comment['UserName']);
		printf('%s</p></div>', $new_comment['CommentText']);
	}
?>

<?php include 'footer.php'; ?>
