<?php
  //include our function set
  include ('book_sc_fns.php');

  // The shopping cart needs sessions, so start one
  session_start();
  do_my_html_header("Checkout");
  display_my_search(false);
  if(!isset($_SESSION['cart'])||!(array_count_values($_SESSION['cart']))) {
    echo "<p>There are no items in your cart.</p>";
    display_button("show_cart.php", "continue-shopping", "Continue Shopping");
    do_html_footer();
    exit;
  }
  $flag = true;
  $conn = db_connect();
  foreach ($_SESSION['cart'] as $isbn => $qty) {
    $result = $conn->query("select * from books where isbn = ".$isbn)->fetch_object();
    if ($result->num < $qty) {
        echo $result->title." 库存不足，请重新选择";
        $flag = false;
    }
  }
  if (!$flag) {
    display_button("show_cart.php", "continue-shopping", "Continue Shopping");
    do_my_html_footer();
    exit;
  }
  else {
      
  }
  if (!isset($_SESSION['valid_user'])) {
    echo '<div class="alert alert-warning" role="alert">
        <strong>You are not logged in.</strong> You must be logged in to check out.
      </div>';
  }
  else if(isset($_SESSION['cart']) &&  (array_count_values($_SESSION['cart']))) {
    display_cart($_SESSION['cart'], false, 0);
    display_checkout_form();
  } else {
    echo "<p>There are no items in your cart</p>";
  }

  display_button("show_cart.php", "continue-shopping", "Continue Shopping");
  display_my_nothing();
  do_my_html_footer();
?>
