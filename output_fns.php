<?php 

function do_html_header($title) {
	//print an html header
?>
	<html>
	<head>
		<title><?php echo $title;?></title>
		<style>
			body {font-family: Arial, Helvetica, sans-serif; font-size: 13px}
			li,td {font-family: Arial, Helvetica, sans-serif; font-size: 13px}
			hr {color: #3333cc; width=300; text-align = left}
			a {color: #000000}
		</style>
	</head>
	<body>
		<img src="bookmark.gif" alt="PHPbookmark logo" border="0"
		align = "left" valign="bottom" height="55" width="57"/>
		<h1>PHPbookmark</h1>
		<hr />
<?php
	if($title) {
		do_html_heading($title);
	}
}

function do_html_footer() {
	//print an html footer
?>
	</body>
	</html>
<?php
}

function do_html_heading($heading) {
	//print heading
?>
	<h2><?php echo $heading;?></h2>
<?php
}

function do_html_URL($url, $name) {
	//output URL as link and br
?>
	<br/><a href="<?php echo $url;?>"><?php echo $name;?></a><br/>
<?php
}

function display_site_info() {
	//display some marketing info
?>
	<ul>
	<li> Store your bookmarks online with us!</li>
	<li>See what other users use!</li>
	<li>Share your favorite links with others!</li>
	</ul>
<?php
}

function display_login_form() {
?>
	<p><a href="registration_form.php">Not a member?</a></p>
	<form method = "post" action="member.php">
		<table bgcolor="#cccccc">
			<tr>
				<td colspan="2">
					Members log in here:
				</td>
			</tr>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username"> </td>
				</tr>
				<tr>
					<td>
						Password:
					</td>
					<td><input type="password" name="passwd"/></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type = "submit" value= "Log in"/>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<a href="forgot_form.php">Forgot your password?</a>
					</td>
				</tr>
		</table>
	</form>
<?php
}

function display_registration_form() {
?>
	<form method="post" action="register_new.php">
		<table bgcolor="#cccccc">
			<tr>
				<td>
					Email address:
				</td>
				<td> 
					<input type = "text" name="email" size="30" maxlength="100">
				</td>
			</tr>
				<tr>
					<td>
						Prefered username <br/>(max 16 chars):
					</td>
					<td valign="top"> 
						<input type="text" name = "username" size = "16" maxlength="16"/>
					</td>
				</tr>
				<tr>
					<td>Password <br/> (between 6 and 16 chars):</td>
					<td valign="top"> <input type="password" name = "passwd" size= "16" maxlength = "16"/>  </td>
				</tr>
				<tr>
					<td>
						Confirm password:
					</td>
					<td>
						<input type = "password" name = "passwd2" size="16" maxlength="16"/>
					</td>
				</tr>
				<tr>
					<td colspan= 2 align="center">
						<input type = "submit" value = "Register">
					</td>
				</tr>
		</table>
	</form>	
<?php
}
