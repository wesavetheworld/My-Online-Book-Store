<?php
function process_card($card_details) {
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details) {
  // extract order_details out as variables
  extract($order_details);

  // set shipping address same as address
  $conn = db_connect();
  $id = $_SESSION['valid_user'];
  $result = $conn->query("select * from customers where customerid = '".$id."'")->fetch_object();
  if (($ship_name=="") || ($ship_address=="") || ($ship_email=="") || ($ship_phonenum=="") ) {
    $ship_name = $result->name;
    $ship_address = $result->address;
    $ship_email = $result->email;
    $ship_phonenum = $result->phonenum;
  }

  $conn = db_connect();

  // we want to insert the order as a transaction 事务
  // start one by turning off autocommit
  $conn->autocommit(FALSE);

  // insert customer address
  /*$query = "select customerid from customers where
            name = '".$name."' and address = '".$address."'
            and city = '".$city."' and state = '".$state."'
            and zip = '".$zip."' and country = '".$country."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    $customer = $result->fetch_object();
    $customerid = $customer->customerid;
  } else {
    $query = "insert into customers values
            ('', '".$name."','".$address."','".$city."','".$state."','".$zip."','".$country."')";
    $result = $conn->query($query);

    if (!$result) {
       return false;
    }
  }*/

  $customerid = $_SESSION['valid_user'];

  $date = date("Y-m-d");

  $query = "insert into orders values
            ('', '".$customerid."', '".$ship_phonenum."','".$ship_email."','".$_SESSION['total_price']."', '".$date."', 'ORDERED',
             '".$ship_name."', '".$ship_address."')";

  $result = $conn->query($query);
  if (!$result) {
    return false;
  }

  $query = "select orderid from orders where
               customerid = '".$customerid."' and
               amount > (".$_SESSION['total_price']."-.001) and
               amount < (".$_SESSION['total_price']."+.001) and
               date = '".$date."' and
               order_status = 'ORDERED' and
               ship_name = '".$ship_name."' and
               ship_address = '".$ship_address."' and
               ship_email = '".$ship_email."' and
               ship_phonenum = '".$ship_phonenum."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    $order = $result->fetch_object();
    $orderid = $order->orderid;
  } else {
    return false;
  }

  // insert each book
  foreach($_SESSION['cart'] as $isbn => $quantity) {
    $detail = get_book_details($isbn);
    $query = "delete from order_items where
              orderid = '".$orderid."' and isbn = '".$isbn."'";
    $result = $conn->query($query);
    $query = "insert into order_items values
              ('".$orderid."', '".$isbn."', ".$detail['price'].", $quantity)";
    $result = $conn->query($query);
    if(!$result) {
      return false;
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

?>
