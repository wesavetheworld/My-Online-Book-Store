<?php

  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  do_my_html_header("Checkout");
  display_my_search(false);
  $conn = db_connect();
  $id = $_SESSION['valid_user'];
  $result = $conn->query("select * from customers where customerid = '".$id."'")->fetch_object();
  $name = $result->name;
  // if filled out
  if (($_SESSION['cart'])) {
    // able to insert into database
    if(insert_order($_POST) != false ) {
      //display cart, not allowing changes and without pictures
      display_cart($_SESSION['cart'], false, 0);

      display_shipping(calculate_shipping_cost());

      //get credit card details
      display_card_form($name);

      display_button("show_cart.php", "continue-shopping", "Continue Shopping");
    } else {
      echo "<p>Could not store data, please try again.</p>";
      display_button('checkout.php', 'back', 'Back');
    }
  } else {
    echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    display_button('checkout.php', 'back', 'Back');
  }

  do_my_html_footer();
?>
