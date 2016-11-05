<?php if(!isset($_COOKIE['HWP_cookie_consent']) OR $_COOKIE['HWP_cookie_consent']!="yes"){?>
<div id="cookie-banner">
  <div id="cookie-container">
    <p id="cookie-§">This website uses cookies. By continuing your navigation, you accept our use of these cookies. Remember that we are deeply commited to protect your data and your privacy, so we won't use them to track you nor to sell your private information to an advertiser. <a href="our_policy.php#cookies">Learn more about our policy and our use of your cookies...</a></p>
    <button id="cookie_hide" onclick="
      document.getElementById('cookie-banner').style.display = 'none';
    ">OK!</button>
  </div>
</div>
<?php }?>
<header>
  <?php if(!isset($_SESSION['userID'])){?>
    <a href=<"login.php"><div id="user"><?php
    }
    if (isset($_SESSION['username'])){
      echo $_SESSION['username'];
    } else {
      echo 'Log In';
    }
  ?></div></a>
  <a href="index.php"><h1>HWP</h1></a>
  <div id="addSearch">
    <?php
      if (isset($_SESSION['userID'])) {
    ?>
        <div id="add">ADD</div>
    <?php
      }
    ?>
    <a href="search.php">SEARCH</a>
  </div>
</header>
<?php
  if (isset($_SESSION['userID'])) {
?>
    <div id="userSub">
      <a href=
        <?phpecho '"user.php?uID=' . $_SESSION['userID'] . '"';?>>My profile</a>
      <a href="disconnect.php">Log out</a>
    </div>
    <div id="addSub">
      <a href="addHomework.php">HOMEWORK</a>
      <a>SESSION</a>
      <a>EXAM</a>
    </div>
<?php
  }
?>
