<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (isset($_SESSION['regType']) AND isset($_SESSION['userID']) AND ($_SESSION['regType']=="student" OR $_SESSION['regType']=="teacher" OR $_SESSION['regType']=="staff" OR $_SESSION['regType']=="head" OR $_SESSION['regType']=="inde")){
    if ($_SESSION['regType']=="inde") {
      header('Location: index.php');
    }
  } else {
    header('Location: signup.php?uncomplete=1');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include("sharedParts/head.php"); ?>
  </head>
  <body>
    <?php include("sharedParts/header.php"); ?>
    <section id="oneMoreStep">
      <h2>Just one more step ...</h2>
      <?php
      if ($_SESSION['regType'] == "student") {
        ?>
        <p>So, you're a student ... Please tell us your school's ID to complete your registration :</p>
        <form action="postRegisterConfirm.php" method="post">
          <label for="teacherIDIn">Your teacher's ID :</label>
          <input class="inputText" type="text" name="teacherIDIn" id="teacherIDIn">
          <input type="submit" name="submitButton" value="Send" class="formButton">
        </form>
        <?php
      } elseif ($_SESSION['regType'] == "teacher") {
        ?>
        <p>So, you're a teacher ... Please tell us the ID of a member of the staff of your school or the ID of the head teacher to complete your registration :</p>
        <form action="postRegisterConfirm.php" method="post">
          <label for="staHeaIDIn">Your staff member's / head teacher's ID :</label>
          <input class="inputText" type="text" name="staHeaIDIn" id="staHeaIDIn">
          <input type="submit" name="submitButton" value="Send" class="formButton">
        </form>
        <?php
      } elseif ($_SESSION['regType'] == "staff") {
        ?>
        <p>So, you're a staff member ... Please tell us the ID  of the head teacher of your school to complete your registration :</p>
        <form action="postRegisterConfirm.php" method="post">
          <label for="heaIDIn">Your head teacher's ID :</label>
          <input class="inputText" type="text" name="heaIDIn" id="heaIDIn">
          <input type="submit" name="submitButton" value="Send" class="formButton">
        </form>
        <?php
      } elseif ($_SESSION['regType'] == "head") {
        ?>
        <p>So, you're a head teacher ... Please tell us the name of your school to complete your registration :</p>
        <form action="postRegisterConfirm.php" method="post">
          <label for="schoolNameIn">Your school's name :</label>
          <input class="inputText" type="text" name="schoolNameIn" id="schoolNameIn">
          <input type="submit" name="submitButton" value="Send" class="formButton">
        </form>
        <?php
      }
      ?>
    </section>
  </body>
</html>
