<?php

function db_connect() {
   $result = new mysqli('localhost', 'root', '', 'book_sc');
   if (!$result) {
      return false;
   }
   $result->autocommit(TRUE);
   $result->query('SET NAMES UTF8');//解决phpMyAdmin中文乱码
   return $result;
}

function db_result_to_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {//fetch_assoc(): Fetch a result row as an associative array
     $res_array[$count] = $row;
   }

   return $res_array;
}

?>
