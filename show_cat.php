<?php
//显示特定目录所包含的图书
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $catid = $_GET['catid'];
  $name = get_category_name($catid);

  do_my_html_header($name);
  display_my_search();
  // get the book info out from db
  $book_array = get_books($catid);

  if (!$book_array) {
    display_my_books(array(),"No books currently available in this category");
  }
  else display_my_books($book_array,'',$catid);

  display_my_categories(get_categories());
  // if logged in as admin, show add, delete book links
  if(isset($_SESSION['admin_user'])) {
    display_button("index.php", "continue", "Continue Shopping");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button("edit_category_form.php?catid=".$catid,
                   "edit-category", "Edit Category");
  } else {
    display_button("index.php", "continue-shopping", "Continue Shopping");
  }

  do_my_html_footer();
?>
