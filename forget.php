<?php
/**
 * 
 * @authors linzebing
 * @date    2015-07-02 20:48:39
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
do_my_html_header('忘记密码');
if (!isset($_SESSION['flag'])) {
?>
	
	
    <form method="post" action="resetpasswd.php">
    	<tr> 请输入你的邮箱 </tr>
                <td>
                <input type="text" name="email" size="40" maxlength="40"
          value="" />
                <input class = 'tn btn-lg btn-warning' type='submit' value='重置密码' />
                </form></td>

<?php
} else {
	echo '<div class="alert alert-success" role="alert">
        <strong>您的密码已经被重置。</strong> 新的密码已经发到了您的邮箱。
      </div>';
      unset($_SESSION['flag']);
}
do_my_html_footer();