<?php

require_once('db_fns.php');

function register($username, $email, $passwd, $phonenum, $address, $name) {
    $conn = db_connect();

    $result = $conn->query("select * from customers where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }

  if ($result->num_rows>0) {
    throw new Exception('That username is taken - go back and choose another one.');
  }

  // if ok, put in db
  $result = $conn->query("insert into customers values
                         ('','".$name."','".$phonenum."','".$address."','".$username."',sha1('".$passwd."'), '".$email."')");
  if (!$result) {
    throw new Exception('Could not register you in database - please try again later.');
  }
  return true;
}

function login($username, $password) {
// check username and password with db
// if yes, return true
// else return false

  // connect to db
  $conn = db_connect();
  if (!$conn) {
    return 0;
  }

  // check if username is unique
  $result = $conn->query("select * from admin
                         where username='".$username."'
                         and password = sha1('".$password."')");
  if (!$result) {
     return 0;
  }

  if ($result->num_rows>0) {
     return 1;
  } else {
     return 0;
  }
}

function check_admin_user() {
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['admin_user'])) {
    return true;
  } else {
    return false;
  }
}

function change_password($username, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  if (login($username, $old_password)) {

    if (!($conn = db_connect())) {
      return false;
    }

    $result = $conn->query("update admin
                            set password = sha1('".$new_password."')
                            where username = '".$username."'");
    if (!$result) {
      return false;  // not changed
    } else {
      return true;  // changed successfully
    }
  } else {
    return false; // old password was wrong
  }
}

function user_login($username, $password) {
  $conn = db_connect();
  $result = $conn->query("select customerid from customers
                         where username='".$username."'
                         and passwd = sha1('".$password."')");
  if (!$result) {
    throw new Exception("Could not log you in.", 1);
  } 
  if ($result->num_rows>0) {
    return $result->fetch_object()->customerid; //$result->fetch_object  返回当前行
  } else {
    throw new Exception("Could not log you in.", 1);
  }
}

function check_valid_user() {
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_user']))  {
      echo "You are logged in. Welcome!<br />";
  } else {
     // they are not logged in
     do_html_heading('Problem:');
     echo 'You are not logged in.<br />';
     do_html_url('login.php', 'Login');
     do_html_footer();
     exit;
  }
}


?>
