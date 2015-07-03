<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-01 21:20:35
 * @version $1$
 */

session_start();
require_once('book_sc_fns.php');
do_my_html_header("");

if (isset($_POST['name'])&&isset($_POST['address'])&&isset($_POST['phonenum'])&&isset($_POST['email'])) {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phonenum = $_POST['phonenum'];
	$email = $_POST['email'];
	$conn = db_connect();
	$result = 
	$conn->query("update customers set name = '".$name."', address = '".
	$address."', phonenum = '".$phonenum."', email = '".$email."' where customerid = '".$_SESSION['valid_user']."'");
	if (!$result) {
		echo '<div class="alert alert-warning" role="alert">
        <strong>Something wrong happened.</strong>
      </div>';
	} else {
		echo '<div class="alert alert-success" role="alert">
        <strong>Update successful.</strong>
      </div>';
	}
} else {
	echo '<div class="alert alert-success" role="alert">
        <strong>Failure.</strong> Please fill in the form.
      </div>';
}




do_my_html_footer();

