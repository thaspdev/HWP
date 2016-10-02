<?php
  session_start();
  include("sharedParts/connectDB.php");
?>
<html>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>Add homework - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php"); ?>
    <section id="addHW">
      <h1>ADD HOMEWORK</h1>
      <form action="postaddHW.php" method="post">
        <div class="subForm">
          <label for="HWNameIn">Name :</label>
          <input class="inputText" type="text" name="HWNameIn" id="HWNameIn"></input>
        </div>
        <div class="subForm">
          <label for="descriptionIn">Description :</label>
          <input class="inputText" type="text" name="descriptionIn" id="descriptionIn"></input>
        </div>
        <div class="subForm">
          <label for="typeIn">Type :</label>
          <input class="inputText" type="text" name="typeIn" id="typeIn"></input>
        </div>
        <div class="subForm">
          <label for="durationIn">Duration (in minutes) :</label>
          <input class="inputText" type="date" min="0" name="durationIn" id="durationIn"></input>
        </div>
      </form>
    </section>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>
