<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-30 20:20:48
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
try {
	if (isset($_GET['search_mode']) && isset($_GET['search_request'])) {
		$search_mode = $_GET['search_mode'];
		$search_request = $_GET['search_request'];
		$conn = db_connect();
		$result = "";
		$query = "select * from books 
        where ".$search_mode." LIKE '%".$search_request."%'";
        $result = @$conn->query($query);
        if (!$result) {
		    throw new Exception("抱歉，没有找到".$search_request, 1);
		}
		$num_books = @$result->num_rows;
		if ($num_books == 0) {
		    throw new Exception("抱歉，没有找到".$search_request, 1);
		}		
		$result = db_result_to_array($result);
		do_my_html_header("搜索结果:");
		display_my_search();

		display_my_books($result,'搜索结果:');
		display_my_categories(get_categories());
		do_my_html_footer();
	} else {
		throw new Exception("Please enter something.", 1);
	}
}
 catch (Exception $e){
 	do_my_html_header($e->getMessage());
  	display_my_search();
  	display_my_books(array(),$e->getMessage());
  	//display_my_nothing();
  	display_my_categories(get_categories());
  	do_my_html_footer();
 }

