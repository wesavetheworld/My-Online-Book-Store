<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-28 21:37:56
 * @version $1$
 */

require_once('bookmark_fns.php');

$email = $_POST['email'];
$username = $_POST['username'];
$passwd = $_POST['passwd'];
$passwd2 = $_POST['passwd2'];

session_start();
try {
	//check forms filled in
	if (!filled_out($_POST)) {
		throw new Exception("You have not filled the form out correctly - please go back and try again,");
	}

	//check email address
	if (!valid_email($email)) {
		throw new Exception("That's not a valid email address. Please go back and try aagin");
	}

	//password confirmation
	if ($passwd != $passwd2) {
		throw new Exception("Passwords don't match - please go back and try again");
	}

	//check password form
	if ((strlen($passwd)<6)|| (strlen($passwd)>16)) {
		throw new Exception("You password must be between 6 and 16 characteers. Please go back and try again.");
	}

	//attemp to register
	register($username, $email, $passwd);
	//register session variable
	$_SESSION['valid_user'] = $username;

	//provide link to members page
	do_html_header('Registration sucessful');
	echo 'Your registration was sucessful. Go to the members page and start setting up your bookmarks!';
	do_html_url('members.php','Go to members page');
	do_html_footer();
}

catch (Exception $e) {
	do_html_header('Problem:');
	echo $e->getMessage();
	do_html_footer();
	exit;
}
