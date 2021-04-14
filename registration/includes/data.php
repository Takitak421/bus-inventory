<?php

/* // for authenticating insert
function loginForInsert($username, $password) {
	if(isValidLoginInsertEdit($username, $password)) {
		session_start();
		$_SESSION['GWENITAKITAK'] = session_id; //session_id;

		header("Location: admin/insert.php");
	}
	else
	{
		header("Location: admin/login.php?insert_login_error=Invalid Login");
	}
}
/* // for authenticating edit
function loginForEdit($username, $password) {
	if(isValidLoginInsertEdit($username, $password)) {
		session_start();
		$_SESSION['GWENITAKITAK'] = session_id;

		header("Location: edit.php");
	} else {
		header("Location: login.php?insert_login_error=Invalid Login");
	}
} */


/* function isRightLoggedIn() {
	session_start();
	if(isset($_SESSION['GWENITAKITAK']) /*&& 
	   isset($_SESSION['user']))*/ /* {
		return true;
	} else {
		return false;
	}
}

function isValidLoginInsertEdit($username, $password) {
	
	// you would get this from a database.
	$real_username = "rbondoc3";
	$real_password = password_hash('Gwendolinemeliz143111', 
										PASSWORD_DEFAULT);
	if($username == $real_username &&
		password_verify($password, $real_password)) {
		return true;
	} else {
		return false;
	}
} */

$my_username = "rbondoc3";
$my_password = password_hash('Gwendolinemeliz143111', 
										PASSWORD_DEFAULT);