<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-01 17:18:10
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
do_my_html_header('Home');
display_modify_form();
do_my_html_footer();