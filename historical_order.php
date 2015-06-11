<?php
/**
 * 
 * @authors linzebing
 * @date    2015-06-09 21:58:24
 * @version $1$
 */
require_once('book_sc_fns.php');
session_start();
do_my_html_header("历史订单");
echo "<h1>订单详情:</h1><br>";
display_historical_order($_SESSION['valid_user']);
do_my_html_footer();
