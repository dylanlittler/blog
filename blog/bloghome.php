<?php
	$title = 'Coding Linguist - Blog';
	include 'header.php';
	include 'connection.php';

	$post_limit = 5;

	if (isset($_GET['page'])) {
		$page_num = $_GET['page'];
	} else {
		$page_num = 0;
	}

	$post_range = $page_num * $post_limit;

	$sql = "SELECT * FROM blogs ORDER BY created_date DESC LIMIT $post_range, $post_limit";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$text = $row["blog_text"];
			$link = "blogpost.php?id=" . $row["blog_id"];
			$sentence_num = 4;
			if (count(explode('. ', $text)) < 4) {
				$sentence_num = count(explode('. ', $text));
			}
			$preview = implode('. ', array_slice(explode('. ', $text), 0, $sentence_num));
			printf("<div><h1><a class=\"bloglist\" href=\"%s\">%s</a></h1></div>%s.<p class='keep-reading'><a href=\"%s\">Continue reading -></a></p>", $link, $row["title"], $preview, $link);
		}
	} else {
		echo "<p>Sorry, this page could not be found.</p>";
	}


	$sql = "SELECT blog_id FROM blogs";
	$records = $conn->query($sql);
	$post_count = $records->num_rows;
	$conn->close();
	if (floor($post_count / $post_limit) - 1 == $page_num) {
		$next_page = $page_num;
		$next_style = "none";
	} else {
		$next_page = $page_num + 1;
		$next_style = "block";
	}

	if ($page_num == 0) {
		$previous_page = 0;
		$previous_style = "none";
	} else {
		$previous_page = $page_num - 1;
		$previous_style = "block";
	}

?>

<div class="page-nav" style="display:<?php echo $next_style; ?>"><a href="bloghome.php?page=<?php echo $next_page; ?>">Older Posts</a></div>
<div class="page-nav" style="display:<?php echo $previous_style; ?>"><a href="bloghome.php?page=<?php echo $previous_page; ?>">Newer Posts</a></div>


<?php
	include 'footer.php';
?>
