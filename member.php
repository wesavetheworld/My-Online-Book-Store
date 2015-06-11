<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-31 10:40:49
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
if (!isset($_SESSION['valid_user'])) {
	$username = @$_POST['username'];
	$passwd = @$_POST['passwd'];

	if (isset($username)&& isset($passwd)) {
		try {
			$customerid = user_login($username,$passwd);
			$_SESSION['valid_user'] = $customerid;
		} catch (Exception $e) {
			do_my_html_header('Problem:');
			echo '<div class="alert alert-danger" role="alert">
        <strong>You could not be logged in.</strong> You must be logged in to view this page.
      </div>';
			//do_html_url('user_login.php',"Login");
			do_my_html_footer();
			exit;
		}
	}
}
do_my_html_header('Home');

check_valid_user();

display_user_menu();

echo "<br>";

do_my_html_footer();

