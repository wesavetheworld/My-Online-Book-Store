<?php
/**
 * 
 * @authors linzebing
 * @date    2015-06-10 16:07:28
 * @version $1$
 */

function do_my_html_header($title = '') {
	if (!isset($_SESSION['items'])) {
	    $_SESSION['items'] = '0';
	}
	if (!isset($_SESSION['total_price'])) {
	  $_SESSION['total_price'] = '0.00';
	}
?>
	<!DOCTYPE html>
<!-- saved from url=(0042)http://v3.bootcss.com/examples/offcanvas/# -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/offcanvas/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Off Canvas Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Online Bookstore</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        	<?php
    if (!isset($_SESSION['valid_user'])) {
      ?>
      	<form action="member.php" method="POST" class="navbar-form navbar-right" >
          <div class="form-group">
		                <input type="text" placeholder="用户名" name = "username" class="form-control" maxlength="80">
		              </div>
          <div class="form-group">
		                <input type="password" placeholder="密码" name="passwd" class="form-control" maxlength="80">
		              </div>
          <input type="submit" class="btn btn-primary" name="action" value="登录">
          <a class="register btn btn-normal btn-success" href="register_form.php">注册</a>
        </form>
      <?php
    } else {
      ?>
      
      <div class="navbar-text pull-right">

              <!-- <li class="dropdown"> -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">账户<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu" align = "center">
                <li><a href="member.php">个人中心</a></li>
                <li class="divider"></li>
                <li><a href="#">修改信息</a></li>
                <li><a href="user_logout.php">登出</a></li>
              </ul>
            <!-- </li> -->
       </div>
      <?php
    }
  ?>
	
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
		  	           
        
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <div class="container">
<?php

}

function display_my_search($flag = true) {
?>

      <div class="row row-offcanvas row-offcanvas-right">
<?php 
	if ($flag) {
		?> 
		<div class="col-xs-12 col-sm-9">
			<?php
	}
        ?>
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div>
				 <form action="search_result.php", method = "get">
<tr>
    <td><select name="search_mode" style="width:60px; height:40px;">
    <option value="title">书名</option>
    <option value="author">作者</option>
    <option value="description">描述</option>
        <option value="isbn">ISBN</option>
        </select>
    </td>
  </tr>
 <tr>
    <td><input type="text" name="search_request" value="" maxlength="100" style="width:300px; height:40px;"></td>
   <input type="submit" class="btn btn-lg btn-primary" hidefocus="true" value="搜索"  data-mod="sr" >
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <?php
     if(isset($_SESSION['admin_user'])) {
       display_my_button('logout.php', 'log-out', 'Log Out');
     } else {
       display_my_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
     }
     echo "<font size = 4>";
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {
       echo "&nbsp;&nbsp;".$_SESSION['items']."件商品,&nbsp;";
     }
     
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {
       echo "共".number_format($_SESSION['total_price'],2)."元";
     }
     echo "</font>";
  ?>
  </tr>
 </form>

          </div>
<?php
}

function display_my_books($book_array,$msg) {
	if (!is_array($book_array)) {
    	echo "<p>No books currently available in this category</p>";
    	return;
  	} 
?>
	<div>
			<h1> <font color = "green"><?php echo $msg; ?> </font> </h1>
		  </div>
          <div class="row">
<?php
	$cnt = 0;
	foreach ($book_array as $row) {
	  echo '<div class="col-xs-6 col-lg-4">';
      $url = "show_book.php?isbn=".$row['isbn'];
        $title = "<img src='".$row['image_url']
                  ."'  height = 150 width = 150>";
        do_my_html_url($url, $title);
        echo '<a href='.$url.'>'.'<h6>'.$row["title"].'</h6>'.'</a>';
        echo $row['author'];
        echo "<br>";
        echo "<font color = '#FF0000'>￥".number_format($row['price'],2)."</font>";
        echo "<br>";
        echo "<br>";
      echo "</div>";
    }
    echo "</div></div>";
}

function display_my_categories($cat_array) {
	if (!is_array($cat_array)) {
     echo "<p>No categories currently available</p>";
     return;
  }
	echo '<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">';
     echo '<a href="#" class="list-group-item active">分类导航</a>';
  foreach ($cat_array as $row)  {
    $url = "show_cat.php?catid=".$row['catid'];
    $title = $row['catname'];
   ?>
   <a href = "<?php echo $url; ?>" class = "list-group-item"><?php echo $title; ?></a>
    <?php
  }
  echo "</div></div></div>";
}

function display_my_nothing() {
  echo "</div>";
}

function do_my_html_url($url, $name) {
  // output URL as link and br
?>
  <a href= <?php echo $url; ?> >  <?php echo $name; ?> </a> 
<?php
}

function do_my_html_footer() {
?>

      <div class="footer">
  <div class="container">
    <hr>
    Powered by <a href="http://php.net/"><font color = "blue">PHP Technologies</font></a> 
    <br>
    Copyright &copy; <a href="https://github.com/linzebing" ><font color = "blue">Zebing Lin(林泽冰)</font></a>.
    <br> All rights reserved.
      </div>
</div>

    </div><!--/.container-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./Off Canvas Template for Bootstrap_files/jquery.min.js"></script>
    <script src="./Off Canvas Template for Bootstrap_files/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./Off Canvas Template for Bootstrap_files/ie10-viewport-bug-workaround.js"></script>

    <script src="./Off Canvas Template for Bootstrap_files/offcanvas.js"></script>
  

</body></html>
<?php
}

function display_my_button($target, $image, $alt) {
  echo "<a  href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a>";
}