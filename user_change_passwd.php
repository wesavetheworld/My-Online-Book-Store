<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-01 22:39:33
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
do_my_html_header('修改密码');
display_user_password_form();
do_my_html_footer();