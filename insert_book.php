<?php

// include function files for this application
require_once('book_sc_fns.php');
session_start();

do_my_html_header("Adding a book");
if (check_admin_user()) {
  if (filled_out($_POST)) {
    if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 30000)) {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "images/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "images/" . $_FILES["file"]["name"];
    } else {
      echo "你上传的文件超过了30KB或者不是jpg以及gif格式";
      do_my_html_footer();
      exit;
    }
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $num = $_POST['num'];
    if(insert_book($isbn, $title, $author, $catid, $price, $description, $num,"images/".$_FILES["file"]["name"])) {
      echo "<p>Book <em>".stripslashes($title)."</em> was added to the database.</p>";
    } else {
      echo "<p>Book <em>".stripslashes($title)."</em> could not be added to the database.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }

  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_my_html_footer();

?>
