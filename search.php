<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html lang='EN'>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>Search - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php");?>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>
