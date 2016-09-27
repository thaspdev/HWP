<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (isset($_SESSION['userID'])) {
    header('Location: user.php?uID=' . $_SESSION['userID']);
  }
?>
<!DOCTYPE html>
<html lang='EN'>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>Log In - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php");?>
    <section id="loginSection">
      <h2>Log In</h2>
      <form action="connect.php" method="post">
        <div class="subForm">
          <label for="usernameIn">Username :</label>
          <input class="inputText" type="text" name="usernameIn" id="usernameIn"></input>
          <?php
            if (isset($_GET['failed']) && $_GET['failed']==1) {
          ?>
            <p class="pWarn">This username does not exist.</p>
          <?php
            }
          ?>
        </div>
        <div class="subForm">
          <label for="passwordIn">Password :</label>
          <input class="inputText" type="password" name="passwordIn" id="passwordIn"></input>
          <?php
            if (isset($_GET['failed']) && $_GET['failed']==2) {
          ?>
            <p class="pWarn">The username and the password do not match.</p>
          <?php
            }
          ?>
        </div>
        <input type="submit" name="submitButton" value="Log in" class="formButton">
      </form>
      <p id="logP">Not a member yet? Sign up!</p>
      <div id="logDiv">
        <a href="signup.php">
          <button class="signButton" id="logSignB" class="signBut">Sign Up</button>
        </a>
      </div>
    </section>
  </body>
</html>
