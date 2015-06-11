<?php
/**
 * 
 * @authors linzebing
 * @date    2015-06-11 15:54:00
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
do_my_html_header('about');
echo "这是上海交通大学计算机系的数据库课程设计。<br>";
echo "这个网站实现了一个电商网站基本的功能。";
echo "我从当当上爬取了所有计算机相关书籍的信息，并作为该图书网站的数据来源。<br>";
echo "我的联系方式:";
do_html_url("linzbeing1995@gmail.com","linzbeing1995@gmail.com");
echo "我的github:";
do_html_url("https://github.com/linzebing","https://github.com/linzebing");
do_my_html_footer();