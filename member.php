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
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];

	if (isset($username)&& isset($passwd)) {
		try {
			$customerid = user_login($username,$passwd);
			$_SESSION['valid_user'] = $customerid;
		} catch (Exception $e) {
			do_my_html_header('Problem:');
			echo 'You could not be logged in. You must be logged in to view this page.';
			do_html_url('user_login.php',"Login");
			do_my_html_footer();
			exit;
		}
	}
}
do_my_html_header('Home');
display_my_search();
check_valid_user();
/*if ($url_array = get_user_urls($_SESSION['valid_user'])) {
	display_user_urls($url_array);
}*/
display_user_menu();
echo "<br>";
do_my_html_footer();

