<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-31 10:40:49
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
$conn = db_connect();
$customerid = -1;
if (!isset($_SESSION['valid_user'])) {
	$username = @$_POST['username'];
	$passwd = @$_POST['passwd'];

	if (isset($username)&& isset($passwd)) {
		try {
			$customerid = user_login($username,$passwd);
			$result = $conn->query("select * from customers where customerid = ".$customerid." and verified = true");
			if (!$result) {
				do_my_html_header('Problem:');
				echo '<div class="alert alert-danger" role="alert">
        <strong>You could not be logged in.</strong> You must be logged in to view this page.
      </div>';
      do_my_html_footer();
			exit;
			} else if ($result->num_rows==0) {
				do_my_html_header('Problem:');
				echo '<div class="alert alert-danger" role="alert">
        <strong>请激活你的账户。</strong>
      </div>';
      do_my_html_footer();
			exit;
			} else
			$_SESSION['valid_user'] = $customerid;
		} catch (Exception $e) {
			do_my_html_header('Problem:');
			echo '<div class="alert alert-danger" role="alert">
        <strong>You could not be logged in.</strong> You must be logged in to view this page.
      </div>';
			do_my_html_footer();
			exit;
		}
	} else {
		
		$token = $_GET['verify'];
		$result = $conn->query("select * from customer_verify where token = '".$token."'");
		if (!$result) {
			do_my_html_header('');
			echo '<div class="alert alert-danger" role="alert">
        <strong>链接失效了。</strong>
      </div>';
      do_my_html_footer();
      exit;
  } else if ($result->num_rows>0) {
  	
  		/*echo '<div class="alert alert-success" role="alert">
        <strong>验证成功。</strong> 你可以随意看看。
      </div>';*/
      $result = $conn->query("select customerid from customers where email in (select email from customer_verify where token = '".$token."')");

      $_SESSION['valid_user'] = $result->fetch_object()->customerid;
      $conn->query("update customers set verified = true where customerid = ".$_SESSION['valid_user']);
      /*do_my_html_footer();
      exit;*/
  } else {
  	do_my_html_header('');
  	echo '<div class="alert alert-danger" role="alert">
        <strong>链接失效了。</strong>
      </div>';
      do_my_html_footer();
      exit;
  }
  
	}
}

do_my_html_header('Home');

check_valid_user();

$best = display_recommendations($_SESSION['valid_user']);

display_my_search();
  //echo "<p>Please choose a category:</p>";

  // get categories out of database
  $cat_array = get_categories();
  display_my_books($best,"你可能感兴趣的图书");
  display_my_categories($cat_array);

display_user_menu();

echo "<br>";

do_my_html_footer();

