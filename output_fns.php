
<?php

function do_html_header($title = '') {
  // print an HTML header

  // declare the session variables we want access to inside the function
  if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = '0';
  }
  if (!isset($_SESSION['total_price'])) {
    $_SESSION['total_price'] = '0.00';
  }
?>
  <html>
  <head>
    <title><?php echo $title; ?></title>
    <style>
      h2 { font-family: Arial, Helvetica, sans-serif; font-size: 22px; color: red; margin: 6px }
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #FF0000; width=70%; text-align=center}
      a { color: #000000 }
      table.one {table-layout: automatic}
    </style>
  </head>
  <body>
  <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
  <tr>
  <td rowspan="2">
  <a href="index.php"><img src="images/Book-O-Rama.gif" alt="Bookorama" border="0"
       align="left" valign="bottom" height="55" width="325"/></a>
  </td>
  <td align="right" valign="bottom">
  <?php
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {
       echo "Total Items = ".$_SESSION['items'];
     }
  ?>
  </td>
  <td align="right" rowspan="2" width="135">
  <?php
     if(isset($_SESSION['admin_user'])) {
       display_button('logout.php', 'log-out', 'Log Out');
     } else {
       display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
     }
  ?>
  </tr>
  <tr>
  <td align="right" valign="top">
  <?php
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {
       echo "Total Price = $".number_format($_SESSION['total_price'],2);
     }
  ?>
  </td>
  </tr>
  <tr><a href="register_form.php">Not a member?</a> 
  <?php
    if (!isset($_SESSION['valid_user'])) {
      ?>
      &nbsp; <a href="user_login.php">User login</a></tr>
      <?php
    } else {
      ?>
      &nbsp; <a href="member.php">My account</a></tr> &nbsp; <a href="user_logout.php">Log out</a></tr>
      <?php
    }
  ?>
  </table>
<?php
  if($title) {
    do_html_heading($title);
  }
}

function do_html_footer() {
  // print an HTML footer
?>
      <!-- <footer id="global-footer">
          <p>Lovingly created and maintained by <a href = "https://github.com/linzebing"> Zebing Lin </a>.</p>
      <hr>
         <p>All Rights Reserved.</p>
        </footer> -->
  <div class="footer">
  <div class="container">
    <hr>
    Powered by <a href="http://php.net/"><font color = "blue">PHP Technologies</font></a> 
    <br>
    Copyright &copy; <a href="https://github.com/linzebing" ><font color = "blue">Zebing Lin(林泽冰)</font></a>.
    <br> All rights reserved.
      </div>
</div>
  </body>
  </html>
<?php
}

function do_html_heading($heading) {
  // print heading
?>
  <h2><?php echo $heading; ?></h2>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a color = "blue" href="<?php echo $url; ?>"><font color = "blue" size= 4><?php echo $name; ?></font></a> <br />
<?php
}

function display_categories($cat_array) {
  if (!is_array($cat_array)) {
     echo "<p>No categories currently available</p>";
     return;
  }
  echo "<ul>";
  foreach ($cat_array as $row)  {
    $url = "show_cat.php?catid=".$row['catid'];
    $title = $row['catname'];
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";
  }
  echo "</ul>";
}

function display_books($book_array) {
  //display all books in the array passed in
  if (!is_array($book_array)) {
    echo "<p>No books currently available in this category</p>";
  } else {
    //create table
    echo "<table width=\"100%\" border=\"0\">";
    //create a table row for each book
    foreach ($book_array as $row) {
      $url = "show_book.php?isbn=".$row['isbn'];
      echo "<tr><td>";
      //if (@file_exists("images/".$row['isbn'].".jpg")) {
        $title = "<img src='".$row['image_url']
                  ."' style=\"border: 1px solid black\"/ height = 150 width = 150>";
        do_html_url($url, $title);
      echo "</td><td>";
      //$title = $row['title']." by ".$row['author'];
      $title = $row['title'];
      ?>

      <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
      <?php
      echo '<font color="#FF0000"> ￥'.$row['price']."<font>";

      echo "</td></tr>";
    }

    echo "</table>";
  }
}

function display_book_details($book) {
  // display all details about this book
  if (is_array($book)) {
    $tmp = $book['url'];
    $tmp = $book['image_url'];
    //echo $tmp;
    echo "<table><tr>";
    //display the picture if there is one
    //if (@file_exists("http://img39.ddimg.cn/82/26/23694049-2_u_2.jpg"))  {
      /*$size = GetImageSize("http://img39.ddimg.cn/82/26/23694049-2_u_2.jpg");
      if(($size[0] > 0) && ($size[1] > 0)) {*/
        $pic = "<img src=\"".$tmp."\"
               width = 250 height = 250 alt = \"该商品暂时没有图片\"/>";
        echo '<td><a color = "red" href ="'.$book['url'].'">'.$pic.'</a></td>';
      //}
   // }

    echo "<td><ul>";
    echo "<li><strong>Author:</strong> ";
    echo $book['author'];
    echo "</li><li><strong>ISBN:</strong> ";
    echo $book['isbn'];
    echo "</li><li><strong>Our Price:</strong> ";
    echo "<font color='red' size = '3'>".number_format($book['price'], 2)."</font>";
    echo "</li><li><strong>Description:</strong> ";
    echo $book['description'];
    echo "</li><li><strong>From:</strong> ";
    echo $book['site'];
    echo "</li><li><strong>库存剩余:</strong> ";
    echo $book['num'],"本";
    echo "</li><li><strong>购买链接:</strong> ";
    echo '<a color = "red" href ="'.$book['url'].'">'.$book['title'].'</a>';
    echo "</li></ul></td></tr></table>";
  } else {
    echo "<p>The details of this book cannot be displayed at this time.</p>";
  }
  echo "<hr />";
}

function display_checkout_form() {
  //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
  <form>
  <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
  <?php
      $conn = db_connect();
      $id = $_SESSION['valid_user'];
      $result = $conn->query("select * from customers where customerid = '".$id."'")->fetch_object();
  ?>
      <tr>
    <td>Name</td>
    <td><?php echo $result->name;  ?></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><?php echo $result->address;  ?></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td><?php echo $result->phonenum;  ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $result->email;  ?></td>
  </tr>
  <tr><th colspan="2" bgcolor="#cccccc">Shipping Address (leave blank if as above)</th></tr>
  </form>
  <form action="purchase.php" method="post">
  <tr>
    <td>Name</td>
    <td><input type="text" name="ship_name" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="ship_address" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td><input type="text" name="ship_phonenum" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="ship_email" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
         your purchase, or Continue Shopping to add or remove items.</strong></p>
     <?php display_form_button("purchase", "Purchase These Items"); ?>
    </td>
  </tr>
  </form>
  </table><hr />
<?php
}

function display_shipping($shipping) {
  // display table row with shipping cost and total price including shipping
?>
  <table border="0" width="100%" cellspacing="0">
  <tr><td align="left">Shipping</td> 
      <td align="right"> <?php echo '￥'; echo number_format($shipping, 2); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ?></td></tr>
  <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right"><?php echo "￥".number_format($shipping+$_SESSION['total_price'], 2); echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"  ?></th>
  </tr>
  </table><br />
<?php
}

function display_card_form($name) {
  //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
  <form action="process.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
  <tr>
    <td>Type</td>
    <td><select name="card_type">
        <option value="VISA">VISA</option>
        <option value="MasterCard">MasterCard</option>
        <option value="American Express">American Express</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Number</td>
    <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
  </tr>
  <tr>
    <td>AMEX code (if required)</td>
    <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
  </tr>
  <tr>
    <td>Expiry Date</td>
    <td>Month
       <select name="card_month">
       <option value="01">01</option>
       <option value="02">02</option>
       <option value="03">03</option>
       <option value="04">04</option>
       <option value="05">05</option>
       <option value="06">06</option>
       <option value="07">07</option>
       <option value="08">08</option>
       <option value="09">09</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       Year
       <select name="card_year">
       <?php
       for ($y = date("Y"); $y < date("Y") + 10; ++$y) {
         echo "<option value=\"".$y."\">".$y."</option>";
       }
       ?>
       </select>
  </tr>
  <tr>
    <td>Name on Card</td>
    <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      add or remove items</strong></p>
     <?php display_form_button('purchase', 'Purchase These Items'); ?>
    </td>
  </tr>
  </table>
<?php
}

function display_cart($cart, $change = true, $images = 1) {
  // display items in shopping cart
  // optionally allow changes (true or false)
  // optionally include images (1 - yes, 0 - no)

   echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
         </tr>";

  //display each item as a table row
  foreach ($cart as $isbn => $qty)  {
    $book = get_book_details($isbn);
    echo "<tr>";
    if($images == true) {
      echo "<td align=\"left\">";
      /*if (file_exists("images/".$isbn.".jpg")) {
         $size = GetImageSize("images/".$isbn.".jpg");
         if(($size[0] > 0) && ($size[1] > 0)) {
           echo "<img src=\"images/".$isbn.".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"".($size[0]/3)."\"
                  height=\"".($size[1]/3)."\"/>";
         }
      } else {*/
         echo "&nbsp;";
      echo "</td>";
    }
    echo "<td align=\"left\">
          <a href=\"show_book.php?isbn=".$isbn."\">".$book['title']."</a>
          </td>
          <td align=\"left\">\$".number_format($book['price'], 2)."</td>
          <td align=\"left\">";

    // if we allow changes, quantities are in text boxes
    if ($change == true) {
      echo "<input type=\"text\" name=\"".$isbn."\" value=\"".$qty."\" size=\"3\">";
    } else {
      echo $qty;
    }
    echo "</td><td align=\"left\">￥".number_format($book['price']*$qty,2)."</td></tr>\n";
  }
  // display total row
  echo "<tr>
        <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            ￥".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";

  // display save change button
  if($change == true) {
    echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"left\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
  }
  echo "</form></table>";
}

function display_login_form() {
  // dispaly form asking for name and password
?>
 <div class="container" >

      <form class="form-signin" method = "post" action="admin.php">
        <h2 class="form-signin-heading">Admin sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" name="username" class="form-control" placeholder="User name" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name = "passwd" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
<?php
}

function display_admin_menu() {
?>
<br />
<div class="col-sm-4">
          <div class="list-group">
            
            <a href="index.php" class="list-group-item">
              <h4 class="list-group-item-heading">回到首页</h4>
            </a>
            <a href="insert_category_form.php" class="list-group-item">
              <h4 class="list-group-item-heading">添加新分类</h4>
              
            </a>
            <a href="insert_book_form.php" class="list-group-item">
              <h4 class="list-group-item-heading">添加书籍</h4>
             
            </a>
            <a href="change_password_form.php" class="list-group-item">
              <h4 class="list-group-item-heading">修改密码</h4>
  
            </a>
          
          </div>
        </div><!-- /.col-sm-4 -->
<?php
}

function display_button($target, $image, $alt) {
  echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
}

function display_form_button($image, $alt) {
  echo "<div align=\"center\"><input type=\"image\"
           src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
}

function display_search() {
?>
    <form action="search_result.php", method = "get">
<tr>
    <td><select name="search_mode" style="width:60px; height:30px;">
    <option value="title">书名</option>
    <option value="author">作者</option>
    <option value="description">描述</option>
        <option value="isbn">ISBN</option>
        </select>
    </td>
  </tr>
 <tr>
    <td><input type="text" name="search_request" value="" maxlength="100" style="width:300px; height:30px;"></td>
   <input type="submit" class="s-submit search-box__button" hidefocus="true" value="搜索"  data-mod="sr" style="width:60px; height:30px;">
  </tr>
 </form>
<?php
}

function display_registration_form() {
?>
  <form method="post" action="register_new.php">
 <table bgcolor="#cccccc">
  <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
  <tr>
    <td>User Name</td>
    <td><input type="text" name="username" value="" maxlength="16" size="20"/></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="passwd" value="" maxlength="16" size="20"/></td>
  </tr>
  <tr>
    <td>Confirm Password</td>
    <td><input type="password" name="passwd2" value="" maxlength="16" size="20"/></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="name" value="" maxlength="40" size="20"/></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td ><input type="text" name="phonenum" value="" maxlength="11" size="20"/></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" value="" maxlength="100" size="20"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" value="" maxlength="40" size="20"/></td>
  </tr>
  <tr>
     <td colspan=4 align="center">
     <input class="register btn btn-normal btn-success" type="submit" value="Register"></td></tr>
  </form>
  </table>
<?php
}

function display_user_login_form() {
?>
  <p><a href="register_form.php">Not a member?</a></p>
  <form method="post" action="member.php">
  <table bgcolor="#cccccc">
   <tr>
     <td colspan="2">Members log in here:</td>
   <tr>
     <td>Username:</td>
     <td><input type="text" name="username"/></td></tr>
   <tr>
     <td>Password:</td>
     <td><input type="password" name="passwd"/></td></tr>
   <tr>
     <td colspan="2" align="center">
     <input type="submit" value="Log in"/></td></tr>
   <tr>
     <td colspan="2"><a href="forgot_form.php">Forgot your password?</a></td>
   </tr>
 </table></form>
<?php
}

function display_user_menu() {
  // display the menu options on this page
?>
<hr />

<a href="index.php">首页</a> &nbsp;|&nbsp;
<a href="historical_order.php">历史订单</a> &nbsp;|&nbsp;

<a href="user_change_passwd.php">Change password &nbsp;|&nbsp;</a>
<a href="user_logout.php">Log out</a>


<?php
}

function display_historical_order($id) {
    $conn = db_connect();
    $result = $conn->query("select * from orders where customerid = ".$id);
    $arr = array();
    while ($row = $result->fetch_assoc()) {
      echo "日期: ".$row['date']."&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "金额: ".$row['amount']."元"."&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "状态: ".$row['order_status']."&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "收货人: ".$row['ship_name']."&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "收货地址: ".$row['ship_address']."&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "<a href = 'show_order.php?orderid=".$row['orderid']."&amount=".$row['amount']."'> <font color = 'blue'>订单详情 </font> </a>";
      echo "<br>";
    }
}

function display_reviews($isbn,$isuser = true) {
?>

<?php
  $conn = db_connect();
  $query = "select * from book_reviews where isbn = '".$isbn."' order by posted DESC";
  $result = @$conn->query($query);
  if (!$result) {
   echo "Something wrong happened.";
  }
  else {
    while ($row = $result->fetch_assoc()) {
      $query = "select name from customers where customerid = ".$row['customerid'];
     //echo $query;
      $name = $conn->query($query)->fetch_object()->name;
      $posted = $row['posted'];
      $review = $row['review'];
      $rid = $row['rid'];
      /*echo "<div class='page-header'>
        <h4>$name &nbsp; $posted</h4>
      </div>";*/
      $url = "delete_review.php?rid=".$rid."&isbn=".$isbn;
      if ($isuser) 
        echo "<h4> $name  &nbsp; $posted </h4>";
      else echo "<h4> $name  &nbsp; $posted <a href = $url> <font color = 'blue'> 删除 </font></a> </h4>";
      echo "<div class='well'>
        <p> $review </p>
      </div>";
    }
  }
}


function display_review_form($myisbn) {
?>
  <table cellpadding="0" cellspacing="0" border="0" align = "center">
  <form action="store_new_post.php?isbn=<?php echo $myisbn ?>"
        method="post">
    <div align = "center"> 
      <textarea name="review" rows="3" cols="120"></textarea>
    </div>
    <div align = "center"><button class="btn btn-lg btn-primary btn-block" type="submit">评论</button></div>
  </form>
  </table>
<?php
}

function display_modify_form() {
  //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
  <form>
  <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
  <?php
      $conn = db_connect();
      $id = $_SESSION['valid_user'];
      $result = $conn->query("select * from customers where customerid = '".$id."'")->fetch_object();
  ?>
      <tr>
    <td>Name</td>
    <td><?php echo $result->name;  ?></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><?php echo $result->address;  ?></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td><?php echo $result->phonenum;  ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $result->email;  ?></td>
  </tr>
  <tr><th colspan="2" bgcolor="#cccccc">修改信息 </th></tr>
  </form>
  <form action="modify_info.php" method="post">
  <tr>
    <td>Name</td>
    <td><input type="text" name="name" value="<?php echo $result->name;  ?>" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" value="<?php echo $result->address;  ?>" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td><input type="text" name="phonenum" value="<?php echo $result->phonenum;  ?>" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" value="<?php echo $result->email;  ?>" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <button class="btn btn-lg btn-primary btn-block" type="submit">保存</button>
    </td>
  </tr>
  </form>
  </table>
<?php
}

function display_user_password_form() {
// displays html change password form
?>
   <br />
   <form action="user_change_passwd_process.php" method="post">
   <table width="400" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Old password:</td>
       <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
   </tr>
   <tr><td colspan=2 align="left"><input class = "tn btn-lg btn-info" type="submit" value="Change password">
   </td></tr>
   </table>
   <br />
<?php
}

?>
