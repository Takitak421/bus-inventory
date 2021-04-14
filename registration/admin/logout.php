<?php
session_start();
if (isset($_SESSION['GWENITAKITAK']))
{
  
}
session_destroy();
header("Location:insert.php");
include(__DIR__."/../includes/header_template.php");
?>