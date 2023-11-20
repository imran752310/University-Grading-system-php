// error_reporting(0);


// session_destroy();
// header("location:index.php");
<?php
include('includes/connection.php');
session_start();
session_destroy();
header("location:index.php");

?>