<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-01 11:19:57
 * @version $1$
 */

include ('book_sc_fns.php');
session_start();
$rid = $_GET['rid'];
$isbn = $_GET['isbn'];
do_my_html_header();
if (!isset($_SESSION['admin_user'])) {
	echo '<div class="alert alert-danger" role="alert">
        <strong>You are not logged in.</strong> You must be logged in to comment.
      </div>';
      do_my_html_footer();
      exit;
}
$conn = db_connect();
$query = "delete from book_reviews where rid=".$rid;
$result = $conn->query($query);
if (!$result) {
	echo "Something wrong happened.";
} else {
	$url = "show_book.php?isbn=".$isbn;
	echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0.001;url=$url\">"; 
}
do_my_html_footer();