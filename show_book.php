<?php
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $isbn = $_GET['isbn'];

  // get this book out of database
  $book = get_book_details($isbn);
  $title =$book['title'];
  //$title = $book['title'];
  do_my_html_header($title);
  display_my_search(false);
  display_book_details($book);
  
  // set url for "continue button"
  $target = "index.php";
  if($book['catid']) {
    $target = "show_cat.php?catid=".$book['catid'];
  }
  // if logged in as admin, show edit book links
  if(check_admin_user()) {
    display_reviews($isbn,false);
    display_button("edit_book_form.php?isbn=".$isbn, "edit-item", "Edit Item");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button($target, "continue", "Continue");
  } else {
    display_reviews($isbn);
    display_review_form($isbn);
    display_button("show_cart.php?new=".$isbn, "add-to-cart",
                   "Add".$book['title']." To My Shopping Cart");
    display_button($target, "continue-shopping", "Continue Shopping");
  }

  do_my_html_footer();
?>
