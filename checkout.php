<?php
  //include our function set
  include ('book_sc_fns.php');

  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Checkout");
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
    do_html_footer();
    exit;
  }
  else {
    foreach ($_SESSION['cart'] as $isbn => $qty) {
      $result = $conn->query("select * from bestseller where isbn =".$isbn);
      if (!$result) {
          $conn->query("insert into bestseller values ('".$isbn."','".$qty."')" );
      }
      else if ($result->num_rows==0) {
          $conn->query("insert into bestseller values ('".$isbn."','".$qty."')" );
      }
      else {
        $conn->query("update bestseller set quantity = quantity + ".$qty);
      }
      $result = $conn->query("update books set num = num-".$qty." where isbn = ".$isbn);
      if (!$result) {
        echo "Something wrong happened.";
        exit;
      }
  }
  }
  if (!isset($_SESSION['valid_user'])) {
    echo "<p> You must be logged in to check out. </p>";
  }
  else if(isset($_SESSION['cart']) &&  (array_count_values($_SESSION['cart']))) {
    display_cart($_SESSION['cart'], false, 0);
    display_checkout_form();
  } else {
    echo "<p>There are no items in your cart</p>";
  }

  display_button("show_cart.php", "continue-shopping", "Continue Shopping");

  do_html_footer();
?>
