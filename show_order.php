<?php
/**
 * 
 * @authors linzebing
 * @date    2015-06-09 22:39:43
 * @version $1$
 */

require_once('book_sc_fns.php');
session_start();
do_html_header("订单详情");
$conn = db_connect();
$result = $conn->query("select * from order_items where orderid=".$_GET['orderid']);
echo "<table width=\"100%\" border=\"0\">";
while ($row = $result->fetch_assoc()) {
	$res = $conn->query("select * from books where isbn = ".$row['isbn'])->fetch_object();

      $url = "show_book.php?isbn=".$res->isbn;
      echo "<tr><td>";
      //if (@file_exists("images/".$row['isbn'].".jpg")) {
        $title = "<img src='".$res->image_url
                  ."' style=\"border: 1px solid black\"/ height = 150 width = 150>";
        do_html_url($url, $title);
      echo "</td><td>";
      //$title = $row['title']." by ".$row['author'];
      $title = $res->title;
      ?>

      <a href="<?php echo $url; ?>"><?php echo $title; ?></a>
      <?php
      echo '￥'.number_format($res->price,2)."<br>";
      echo "购买了:".$row['quantity']."册<br>";
      echo "总金额:".$_GET['amount']."元";
      echo "</td></tr>";
	/*echo $res->title;
	echo "<br>";
	echo $row['quantity'];
	echo "<br>";*/
}
echo "</table>";
do_html_footer();