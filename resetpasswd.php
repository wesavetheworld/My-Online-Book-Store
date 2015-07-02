<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-02 20:55:46
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
$email = $_POST['email'];
$newpass = rand(100000,10000000);
$newpass = $email[0].$newpass;
$conn = db_connect();
$conn->query("update customers set passwd = sha1('".$newpass."')");
@sendmail($email,"Bookstore重置密码","您的密码已重置为: <br>".$newpass);
$url = "forget.php";
$_SESSION['flag'] = 1;
echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0.001;url=$url\">"; 
