<?php
include(__DIR__."/../includes/header_template.php");
include_once(__DIR__."/../includes/db.php");
include(__DIR__."/../includes/validate.php");

$isBusDeleted = false;
/* example: 
 * http://rbondoc3.dmitstudent.ca/dmit2025/db-bindpara-selinsupdel/delete.php?id=7
 *
 * */
if ($_SERVER['REQUEST_METHOD'] === "GET") { // step 1: it is a post request
  if (isset($_GET['id'])) { // step 2: if id is in $_GET superglobal
    $bus_data_id = validate_number($_GET['id']); // step 3: validate what user wants
	
	if ($bus_data_id != false){
		$isBusDeleted = delete_bus_by_id($bus_data_id); // step 4: handle the result
	}
  }
}
?>

<!-- this is a template which needs to remove and needs in other file -->
<!doctype html>
<html class="no-js" lang="">

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<div class="container">
		<?php if ($isBusDeleted) { ?>
		<div class="alert alert-success delete-it" role="alert">
			<h3>Entry is successfully deleted!</h3>
			<!-- </?php header("Location:edit.php"); ?> -->
		</div>
		<?php } else { ?>
		<div class="alert alert-danger delete-it" role="alert">
			<h3>Entry is not deleted.</h3>
			<!-- </?php header("Location:edit.php"); ?> -->
		</div>
		<?php }?>
	</div>
</body>

</html>