<?php
  include ('book_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  do_my_html_header('Checkout');
  display_my_search(false);
  $card_type = $_POST['card_type'];
  $card_number = $_POST['card_number'];
  $card_month = $_POST['card_month'];
  $card_year = $_POST['card_year'];
  $card_name = $_POST['card_name'];
  if (!isset($_SESSION['cart'])) {
      echo "<p>There are no items in your cart</p><hr/>";
      display_button("index.php", "continue-shopping", "Continue Shopping");
  }
  else if(isset($_SESSION['cart']) && ($card_type) && ($card_number) &&
     ($card_month) && ($card_year) && ($card_name)) {
    //display cart, not allowing changes and without pictures
    $conn = db_connect();
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
    display_cart($_SESSION['cart'], false, 0);

    display_shipping(calculate_shipping_cost());

    if(process_card($_POST)) {
      //empty shopping cart
      //session_destroy();
      unset($_SESSION['cart']);
      unset($_SESSION['items']);
      unset($_SESSION['total_price']);
      echo "<p>Thank you for shopping with us. Your order has been placed.</p>";
      display_button("index.php", "continue-shopping", "Continue Shopping");
    } else {
      echo "<p>Could not process your card. Please contact the card issuer or try again.</p>";
      display_button("purchase.php", "back", "Back");
    }
  } else {
    echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    display_button("purchase.php", "back", "Back");
  }
  display_my_nothing();
  do_my_html_footer();
?>
