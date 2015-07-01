<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-01 09:39:55
 * @version $1$
 */

include ('book_sc_fns.php');
session_start();
do_my_html_header();
if (!isset($_SESSION['valid_user'])) {
	echo '<div class="alert alert-danger" role="alert">
        <strong>You are not logged in.</strong> You must be logged in to comment.
      </div>';
      do_my_html_footer();
      exit;
}
$customerid = $_SESSION['valid_user'];
$review = $_POST['review'];
$isbn = $_GET['isbn'];
$conn = db_connect();
date_default_timezone_set("Asia/Hong_Kong");
$query = "insert into book_reviews values ('".$isbn."','".date('c')."','".$review."','".$customerid."')";
$result = $conn->query($query);
$url = "show_book.php?isbn=".$isbn;
   if ((!$result)) {
     echo "Something wrong happened.";
     exit;
   }
   else {
   	echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0.01;url=$url\">"; 
   }
