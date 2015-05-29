<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-28 22:04:49
 * @version $1$
 */

function db_connect() {
	$result = new mysqli('localhost','root','','bookmarks');
	if (!$result) {
		throw new Exception("Couldn't connect to  database", 1);
	} else {
		return $result;
	}
}