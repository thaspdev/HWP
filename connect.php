<?php
  session_start();
  include("sharedParts/connectDB.php");
  $UserConnectAnswer = $DB->prepare('SELECT username, hash, salt FROM users WHERE username = ?');
  $UserConnectAnswer->execute(array(htmlspecialchars($_POST['usernameIn'])));
  $UConnectTest = $UserConnectAnswer->fetch();
  if (sha1($UConnectTest['salt'] . $_POST['passwordIn'])==$UConnectTest['hash']) {
    $UserConAnswer = $DB->prepare('SELECT * FROM users WHERE username = ?');
    $UserConAnswer->execute(array(htmlspecialchars($_POST['usernameIn'])));
    $UConnectData = $UserConAnswer->fetch();
    $_SESSION['userID']=(int)$UConnectData['userID'];
    $_SESSION['username']=$UConnectData['username'];
    $_SESSION['email']=$UConnectData['email'];
    $_SESSION['firstName']=$UConnectData['firstName'];
    $_SESSION['lastName']=$UConnectData['lastName'];
    $_SESSION['groupID']=$UConnectData['groupID'];
    header('Location: index.php');
  } else {
    header('Location: login.php?failed=1');
  }
?>
