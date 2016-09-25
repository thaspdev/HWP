<?php
  session_start();
  include("sharedParts/connectDB.php");
  $GUArray = [];
  $MainGUArray = [];
  $GroupsUserAnswer = $DB->prepare('SELECT * FROM groups WHERE groupID IN (SELECT groupID FROM groupMembers WHERE userID = ?)');
  $GroupsUserAnswer->execute(array(htmlspecialchars($_SESSION['userID'])));
  while($GroupsUserData = $GroupsUserAnswer->fetch())
  {
    $GUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
    if($GroupsUserData['isMainGroup']) {
      $MainGUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
    }
  }
?>
<!DOCTYPE html>
<html lang='EN'>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>User - HWP</title>
  </head>
  <body>
    <?php
      include("sharedParts/header.php");
      if (isset($_SESSION['userID']) AND $_GET['uID'] == $_SESSION['userID']) {
        $MyProfileAnswer = $DB->prepare('SELECT * FROM users WHERE userID = ?');
        $MyProfileAnswer->execute(array(htmlspecialchars($_SESSION['userID'])));
        $MyPData = $MyProfileAnswer->fetch();
    ?>
    <section id="myProfile">
      <h2>My profile</h2>
      <p>
        Username : <?php echo $MyPData['username']; ?></br>
        Email address : <?php echo $MyPData['email']; ?></br>
        First name(s) : <?php echo $MyPData['firstName']; ?></br>
        Last name : <?php echo $MyPData['lastName']; ?></br>
        Your profile is set to
        <?php
          if($MyPData['isStudent']) {
            echo ' student.</br>';
        ?>
        Groups : <?php foreach ($GUArray as $key => $value) {
          echo '<a href="search.php?g=1&gID=' . $key . '">' . $value . '</a>';
        } ?>
        <?php
          } elseif ($MyPData['isTeacher']) {
            echo 'Your profile is set to teacher.';
          } elseif ($MyPData['isStaff']) {
            echo 'Your profile is set to member of staff of the school.';
          }
        ?>
      </p>
    </section>
    <?php
      } else {
    ?>

    <?php
      }
    ?>
  </body>
</html>
