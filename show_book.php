<?php
  include ('fns/book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $isbn = $_GET['isbn'];

  // get this book out of database
  $book = get_book_details($isbn);
  index_html_header($book['title']);
  display_book_details($book);

  // set url for "continue button"
  $target = "index.php";
  if($book['catid']) {
    $target = "show_cat.php?catid=".$book['catid'];
  }

  // if logged in as admin, show edit book links
  if(check_admin_user()) {
    display_button("admin/edit_book_form.php?isbn=".$isbn, "edit-item", "Edit Item");
    display_button("admin/admin.php", "admin-menu", "Admin Menu");
    display_button($target, "continue", "Continue");
  } else {
    display_button("cart/show_cart.php?new=".$isbn, "add-to-cart",
                   "Add".$book['title']." To My Shopping Cart");
    display_button($target, "continue-shopping", "Continue Shopping");
  }

  do_html_footer();
?>
