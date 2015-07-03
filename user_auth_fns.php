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
  $result = $conn->query("select * from customers where email='".$email."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }
  if ($result->num_rows>0) {
    throw new Exception('That email is taken - go back and choose another one.');
  }
$result = $conn->query("select * from customers where phonenum='".$phonenum."'");
if (!$result) {
    throw new Exception('Could not execute query');
  }
  if ($result->num_rows>0) {
    throw new Exception('That email is taken - go back and choose another one.');
  }
  $result = $conn->query("select * from customers where phonenum='".$phonenum."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }

  if ($result->num_rows>0) {
    throw new Exception('That phonenum is taken - go back and choose another one.');
  }
  // if ok, put in db
  $result = $conn->query("insert into customers values
                         ('','".$name."','".$phonenum."','".$address."','".$username."',sha1('".$passwd."'), '".$email."',false)");
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

function my_user_change_password($userid, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  try  {
      $conn = db_connect();
  $result = $conn->query("select customerid from customers
                         where customerid='".$userid."'
                         and passwd = sha1('".$old_password."')");
  if (!$result) {
    throw new Exception("Could not log you in.", 1);
  } 
  if ($result->num_rows<=0) {
    throw new Exception("Could not log you in.", 1);
  }

      if (!($conn = db_connect())) {
        return false;
      }

      $result = $conn->query("update customers
                              set passwd = sha1('".$new_password."')
                              where customerid = '".$userid."'");
      if (!$result) {
        return false;  // not changed
      } else {
        return true;  // changed successfully
      }
  }
  catch (Exception $e) {
    echo $e->getMessage();
    }
  
}

function user_login($username, $password) {
  $conn = db_connect();
  $result = $conn->query("select customerid from customers
                         where username='".$username."'
                         and passwd = sha1('".$password."')");
  if (!$result) {
    throw new Exception("Could not log you in1.", 1);
  } 
  if ($result->num_rows>0) {
    return $result->fetch_object()->customerid; //$result->fetch_object  返回当前行
  } else {
    throw new Exception("Could not log you in2.", 1);
  }
}

function check_valid_user() {
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_user']))  {
    echo '<div class="alert alert-success" role="alert">
        <strong>Well done!</strong> You are logged in.
      </div>';
      
  } else {
     // they are not logged in
     do_html_heading('Problem:');
     echo '<div class="alert alert-danger" role="alert">
        <strong>Oh snap!</strong> Change a few things up and try submitting again.
      </div>';
     do_html_url('login.php', 'Login');
     do_my_html_footer();
     exit;
  }
}

function sendmail($receiver, $subject, $content) {
  require_once('book_sc_fns.php');
  $mail = new PHPMailer(true); //实例化PHPMailer类,true表示出现错误时抛出异常
  $mail->IsSMTP(); // 使用SMTP
  try {
    $mail->CharSet ="UTF-8";//设定邮件编码
    $mail->Host       = "smtp.163.com"; // SMTP server
    $mail->SMTPDebug  = 1;// 启用SMTP调试 1 = errors  2 =  messages
    $mail->SMTPAuth   = true;// 服务器需要验证
    $mail->Port       = 25;//默认端口   
    
    $mail->Username   = "noreplyatbookstore"; //SMTP服务器的用户帐号
    $mail->Password   = "hxleowdqawrrmgze";//SMTP服务器的用户密码
    $mail->AddReplyTo('noreplyatbookstore@163.com', '回复'); //收件人回复时回复到此邮箱
   $mail->AddAddress($receiver, 'Bookstore'); //收件人如果多人发送循环执行AddAddress()方法即可 还有一个方法时清除收件人邮箱ClearAddresses()
  $mail->SetFrom('noreplyatbookstore@163.com', 'Bookstore');//发件人的邮箱
  $mail->Subject = $subject;
  $mail->Body = $content;
  $mail->IsHTML(true);
    $mail->Send();
    //echo "Message Sent OK";
    return true;
  } catch (phpmailerException $e) {
    echo $e->errorMessage();//从PHPMailer捕获异常
    return false;
  } catch (Exception $e) {
    echo $e->getMessage();
    return true;
  }
}

?>
