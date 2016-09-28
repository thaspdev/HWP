<?php
  session_start();
  include("sharedParts/connectDB.php");
?>
<!DOCTYPE html>
<html lang='EN'>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>Sign Up - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php");?>
    <section id="signUpSection">
      <h2>Sign Up</h2>
      <form action="register.php" method="post">
        <div class="subForm">
          <?php
            if(isset($_GET['uncomplete']))
            {
              if($_GET['uncomplete'])
              {
                echo '<p class="pWarn">You did not fill all the fields correctly. Please try again.</p>';
              }
            }
          ?>
          <label for="usernameIn">Username :</label>
          <input class="inputText" type="text" name="usernameIn" id="usernameIn"></input>
          <?php
          if(isset($_GET['uNameNotAvail']))
          {
            if($_GET['uNameNotAvail'])
            {
               echo '<p class="pWarn">This username is not available. Please try another one.</p>';
            }
          }
          ?>
        </div>
        <div class="subForm">
          <label for="passwordIn">Password :</label>
          <input class="inputText" type="password" name="passwordIn" id="passwordIn"></input>
        </div>
        <div class="subForm">
          <label for="passwordCheckIn">Verify password :</label>
          <input class="inputText" type="password" name="passwordCheckIn" id="passwordCheckIn"></input>
        </div>
        <div class="subForm">
          <label for="emailIn">Email :</label>
          <input class="inputText" type="email" name="emailIn" id="emailIn"></input>
        </div>
        <div class="subForm">
          <label for="fiNameIn">First Name :</label>
          <input class="inputText" type="text" name="fiNameIn" id="fiNameIn"></input>
        </div>
        <div class="subForm">
          <label for="laNameIn">Last Name :</label>
          <input class="inputText" type="text" name="laNameIn" id="laNameIn"></input>
        </div>
        <div id="supSupRad">
            <label for="isWhatIn">You are :</label>
              <div id="supRad">
              <div id="radio"><label for="isStuIn">a student</label>
              <input class="inputRad" type="radio" name="isWhatIn" id="isStuIn" value="student"></input></div>
              <div id="radio"><label for="isTeaIn">a teacher</label>
              <input class="inputRad" type="radio" name="isWhatIn" id="isTeaIn" value="teacher"></input></div>
              <div id="radio"><label for="isStaIn">a member of the staff</label>
              <input class="inputRad" type="radio" name="isWhatIn" id="isStaIn" value="staff"></input></div>
              <div id="radio"><label for="isHeaIn">a head teacher</label>
              <input class="inputRad" type="radio" name="isWhatIn" id="isHeaIn" value="head"></input></div>
              <div id="radio"><label for="isIndIn">an independent user</label>
              <input class="inputRad" type="radio" name="isWhatIn" id="isIndIn" value="inde"></input></div>
            </div>
        </div>
        <input type="submit" name="submitButton" value="Sign Up" class="formButton" id="signFormBut"></input>
      </form>
    </section>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>
