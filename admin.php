<?php

// include function files for this application
require_once('book_sc_fns.php');
session_start(); 


if (isset($_POST['username']) && isset($_POST['passwd'])) {
	// they have just tried logging in

    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    if (login($username, $passwd)) {
      // if they are in the database register the user id
      $_SESSION['admin_user'] = $username;

   } else {
      // unsuccessful login
      do_my_html_header("Problem:");
      display_my_search(false);
      echo '<div class="alert alert-danger" role="alert">
        <strong>You could not be logged in.</strong> You must be logged in to view this page.
      </div>';
      do_html_url('login.php', 'Login');
      display_my_nothing();
      do_my_html_footer();
      exit;
    }
}

do_my_html_header("Administration");
display_my_search();

if (check_admin_user()) {
  display_admin_menu();
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
display_my_nothing();
display_my_categories(get_categories());
do_my_html_footer();

?>
