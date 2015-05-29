<?php
/**
 * 
 * @authors linzebing
 * @date    2015-05-28 21:51:29
 * @version $1$
 */

function filled_out($form_vars) {
	//test whether each varaible has a value
	foreach ($form_vars as $key => $value) {
		# code...
		if (!isset($key) || ($value=='')) {
			return false;
		}
	}
	return true;
}

function valid_email($address) {
	//check whether an email address is valid
	if (ereg('^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$', $address)) {
		return true;
	}
	else {
		return false;
	}
}