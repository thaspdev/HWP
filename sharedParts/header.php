<header>
  <a href=<?php
    if (isset($_SESSION['userID'])){
      echo '"user.php?uID=' . $_SESSION['userID'] . '"';
    } else {
      echo '"login.php"';
    }
  ?>><div id="user"><?php
    if (isset($_SESSION['username'])){
      echo $_SESSION['username'];
    } else {
      echo 'Log In';
    }
  ?></div></a>
  <a href="index.php"><h1>HWP</h1></a>
  <div id="addSearch">
    <div id="add">ADD</div>
    <a href="search.php">SEARCH</a>
  </div>
</header>
<div id="addSub">
    <a href="addHomework.php">HOMEWORK</a>
    <a>SESSION</a>
    <a>EXAM</a>
</div>
