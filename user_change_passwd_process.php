<?php
 require_once('book_sc_fns.php');
 session_start();
 do_my_html_header('Changing password');
 check_admin_user();
 if (!filled_out($_POST)) {
   echo '<div class="alert alert-danger" role="alert">
        <strong>You have not filled out the form completely.</strong> Please try again.
      </div>';
   do_my_html_footer();
   exit;
 } else {
   $new_passwd = $_POST['new_passwd'];
   $new_passwd2 = $_POST['new_passwd2'];
   $old_passwd = $_POST['old_passwd'];
   if ($new_passwd != $new_passwd2) {
      echo '<div class="alert alert-danger" role="alert">
        <strong>Passwords entered were not the same.</strong> Not changed.
      </div>';
   } else if ((strlen($new_passwd)>16) || (strlen($new_passwd)<6)) {
      echo '<div class="alert alert-danger" role="alert">
        <strong>New password must be between 6 and 16 characters.</strong> Try again.
      </div>';
   } else {
      // attempt update
      if (my_user_change_password($_SESSION['valid_user'], $old_passwd, $new_passwd)) {
         echo '<div class="alert alert-success" role="alert">
        <strong>Success.</strong>
      </div>';
      } else {
         echo '<div class="alert alert-danger" role="alert">
        <strong>Password can not be changed.</strong> Try again.
      </div>';
      }
   }
 }
 do_my_html_footer();
?>
