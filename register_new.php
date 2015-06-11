<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-30 23:17:52
 * @version $1$
 */

require_once('book_sc_fns.php');

$email = $_POST['email'];
$username = $_POST['username'];
$name = $_POST['name'];
$address = $_POST['address'];
$passwd = $_POST['passwd'];
$passwd2 = $_POST['passwd2'];
$phonenum = $_POST['phonenum'];
session_start();
try {
	if (!filled_out($_POST)) {
		throw new Exception("You have not filled the form correctly. Please go back and try again.", 1);
	}
	// email address not valid
    if (!valid_email($email)) {
      throw new Exception('That is not a valid email address.  Please go back and try again.');
    }

    // passwords not the same
    if ($passwd != $passwd2) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($passwd) < 6) || (strlen($passwd) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
    }

    register($username, $email, $passwd, $phonenum, $address,$name);

    $conn = db_connect();
    $result = $conn->query("select * from customers where username='".$username."'")->fetch_object();
    $_SESSION['valid_user'] = $result->customerid;

    do_my_html_header('Registration successful');
    echo '<div class="alert alert-success" role="alert">
        <strong>Registration successful!</strong> Welcome.
      </div>';
    do_my_html_footer();
} catch (Exception $e) {
    do_my_html_header($e->getMessage());
    echo '<div class="alert alert-danger" role="alert">
        <strong>Registration failed.&nbsp;</strong>'.$e->getMessage().'
      </div>';
	do_my_html_footer();
	exit;
}

