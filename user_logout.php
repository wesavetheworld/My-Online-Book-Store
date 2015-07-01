<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-31 11:45:28
 * @version $1$
 */
// include function files for this application
require_once('book_sc_fns.php');
session_start();
$old_user = @$_SESSION['valid_user'];

// store  to test if they *were* logged in
unset($_SESSION['valid_user']);
$result_dest = session_destroy();

// start output html
do_my_html_header('Logging Out');
if (!empty($old_user)) {
  if ($result_dest)  {
    echo "<div class='alert alert-info' role='alert'>
        <strong>Logged out.</strong> 
      </div>";
  } else {
   echo "<div class='alert alert-danger' role='alert'>
        <strong>Oh snap!</strong> Can't log you out.
      </div>";
  }
} else {
  // if they weren't logged in but came to this page somehow
  echo "<div class='alert alert-warning' role='alert'>
        <strong>You were not logged in, and so have not been logged out.</strong> 
      </div>";
}
do_my_html_footer();

