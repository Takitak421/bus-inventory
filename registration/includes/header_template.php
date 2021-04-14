<?php
include("db.php");
	$thisFile = basename($_SERVER['PHP_SELF']);
		switch ($thisFile){
		case "index.php":
			$thisPageTitle = "Home";
		break;

		case "login.php";
			$thisPageTitle = "Login to register";
		break;

		case "login2.php";
			$thisPageTitle = "Login to edit";
		break;

		case "insert.php":
			$thisPageTitle = "Register a New Bus";
		break;

		case "edit.php":
			$thisPageTitle = "Edit bus";
		break;

		case "search.php":
			$thisPageTitle = "Search";
		break;

		case "delete.php":
			$thisPageTitle = "Delete";
		break;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title><?php echo $thisPageTitle; ?></title>
<!-- Bootstrap minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Custom CSS header template -->
<link rel="stylesheet" href="<?php echo THIS_URL?>/css/header-temp.css">

<!-- Bootstrap minified JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
<div id="outercontainer">
	<div id="container">
		<div id="masthead">
			<h1>Bus Registration Database</h1>
		</div><!-- close masthead -->
		<div id="topNav">
			<a href="<?php echo THIS_URL; ?>index.php">Home</a> |  
			<a href="<?php echo THIS_URL; ?>admin/insert.php">Register A New Bus</a> | 
			<a href="<?php echo THIS_URL; ?>admin/edit.php">Edit</a> | 
			<a href="<?php echo THIS_URL; ?>search.php">Search</a> | 
		</div>
	</div>
			