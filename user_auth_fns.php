<?php
/**
 * 
 * linzebing
 * @date    2015-05-28 21:57:57
 * @version $1$
 */

require_once('db_fns.php');

function register($username, $email, $password) {
	//register new person with db
	//return true or error message 

	$conn = db_connect();

	$result = $conn->query("select * from user where username='".$username."'");
	if (!$result) {
		throw new Exception("Couldn't execute query");
	}

	if ($result->num_rows>0) {
		throw new Exception("That username is taken - go back and choose another one");
	}

	$result = $conn->query("select * from user where email='".$email."'");
	if (!$result) {
		throw new Exception("Couldn't execute query");
	}

	if ($result->num_rows>0) {
		throw new Exception("That email is registered - go back and choose another one");
	}

	$result = $conn->query("insert into user values ('".$username."',sha1('".$password."'),'".$email."')");

	if (!$result) {
		throw new Exception("Couldn't register you in database - please try again later.");
	}

	return true;
}

function login($username, $password) {
	//check username and password with db

	$conn = db_connect();

	$result = $conn->query("select * from user where username='".$username."'and passwd = sha1('".$password."')");
	if (!$result) {
		throw new Exception('Could not log you in.');
	}

	if ($result->num_rows>0) {
		return true;
	} else {
		throw new Exception("Could not log you in.", 1);
		
	}
}

function check_valid_user() {
	//see if somebody is logged in and notify them if not
	if (isset($_SESSION['valid_user'])) {
		echo "Logged in as ".$_SESSION['valid_user'].".<br/>";
	} else {
		do_html_heading('Problem:');
		echo 'You are not logged in.<br/>';
		do_html_url('login.php','Login');
		do_html_footer();
		exit;
	}
}