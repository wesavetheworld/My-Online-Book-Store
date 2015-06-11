<?php
//网站首页，显示系统中的图书目录
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_my_html_header("Welcome to Online Bookstore!");
  display_my_search();
  //echo "<p>Please choose a category:</p>";

  // get categories out of database
  $cat_array = get_categories();

  // display as links to cat pages

  //echo "<font color = 'green' size = '14'>Top 10 bestsellers</font>";
  $best = get_bestsellers();
  display_my_books($best,"Bestsellers this month!");
  display_my_categories($cat_array);
  // if logged in as admin, show add, delete, edit cat links
  if(isset($_SESSION['admin_user'])) {
    display_button("admin.php", "admin-menu", "Admin Menu");
  }
  do_my_html_footer();
?>
