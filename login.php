<?php 
/**
 * 包含系统登录表单的页面
 * @authors linzebing
 * @date    2015-05-28 19:45
 * @version $1$
 */
	require_once('bookmark_fns.php');
	do_html_header('');

	display_site_info();
	display_login_form();

	do_html_footer();
?>