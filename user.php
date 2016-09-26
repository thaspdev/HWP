<?php
  session_start();
  include("sharedParts/connectDB.php");
  $GUArray = [];
  $MainGUArray = [];
  $GUIDArray = [];
  $MainGUIDArray = [];
  $GroupsUserAnswer = $DB->prepare('SELECT * FROM groups WHERE groupID IN (SELECT groupID FROM groupMembers WHERE userID = ?)');
  $GroupsUserAnswer->execute(array(htmlspecialchars($_SESSION['userID'])));
  while($GroupsUserData = $GroupsUserAnswer->fetch())
  {
    $GUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
    if($GroupsUserData['isMainGroup']) {
      $MainGUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
    }// Makes groups' IDs correspond to their names
    $GUArrayID[$GroupsUserData['groupID']] = $GroupsUserData['groupID'];
    if($GroupsUserData['isMainGroup']) {
      $MainGUIDArray[$GroupsUserData['groupID']] = $GroupsUserData['groupID'];
    }//A list of all the IDs of the user's groups
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
      if (isset($_SESSION['userID']) AND isset($_GET['uID']) AND $_GET['uID'] == $_SESSION['userID']) {
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
            echo ' student.';
          } elseif ($MyPData['isTeacher']) {
            echo 'teacher.';
          } elseif ($MyPData['isStaff']) {
            echo 'member of staff of the school.';
          } elseif ($MyPData['isHeadTeacher']) {
            echo 'head teacher.';
          } elseif ($MyPData['isInde']) {
            echo 'independent.';
          }
        ?> </br>
        Groups : <?php
          if (!empty($GUArray)) {
            foreach ($GUArray as $key => $value) {
              echo '<a href="search.php?g=1&gID=' . $key . '">' . $value . '</a>';
            }
          } else {
            echo "you do not belong to any group";
          }
        ?>
      </p>
    </section>
    <?php
  } else {
    $PermArray = []; //Array containing the list of permissions for the connected USER
    $PermProfileAnswer = $DB->prepare('SELECT * FROM permissions WHERE (allowingTypeID = 1 AND allowingID = ? AND (allowedTypeID = 0 OR (allowedTypeID = 1 AND allowedID = ?) OR (allowedTypeID = 2 AND allowedID IN (SELECT groupID FROM groupMembers WHERE userID = ?))) AND permissionTypeID BETWEEN 0 AND 5)');
    $PermProfileAnswer->execute(array(htmlspecialchars($_GET['uID']),htmlspecialchars($_SESSION['userID']),htmlspecialchars($_SESSION['userID'])));
    while($PermPData = $PermProfileAnswer->fetch()){
      if ($PermPData['permissionTypeID'] == 0) {
          $PermArray = [0];
      } else {
          array_push($PermArray, $PermPData['permissionTypeID']);
      }
      }
    // Asks the database if the user is allowed to see the page
    if (!empty($PermArray)) {
      $ProfileAnswer = $DB->prepare('SELECT * FROM users WHERE userID = ?');
      $ProfileAnswer->execute(array(htmlspecialchars($_GET['uID'])));
      $PData = $ProfileAnswer->fetch();
    ?>
    <section id="userProfile">
      <h2>PROFILE</h2>
      <p>
        Username : <?php
          if (in_array(1, $PermArray) || in_array(0, $PermArray)) {
            echo $PData['username'];
          } else {
            echo "you are not allowed to see that";
          }
        ?></br>
        Email address : <?php
          if (in_array(2, $PermArray) || in_array(0, $PermArray)) {
            echo $PData['email'];
          } else {
            echo "you are not allowed to see that";
          }
        ?></br>
        First name(s) : <?php
          if (in_array(3, $PermArray) || in_array(0, $PermArray)) {
            echo $PData['firstName'];
          } else {
            echo "you are not allowed to see that";
          }
        ?></br>
        Last name : <?php
          if (in_array(4, $PermArray) || in_array(0, $PermArray)) {
            echo $PData['lastName'];
          } else {
            echo "you are not allowed to see that";
          }
        ?></br>
        Their profile is set to
        <?php
          if (in_array(5, $PermArray) || in_array(0, $PermArray)){
            if($PData['isStudent']) {
              echo ' student.';
            } elseif ($PData['isTeacher']) {
              echo 'teacher.';
            } elseif ($PData['isStaff']) {
              echo 'member of staff of the school.';
            } elseif ($PData['isHeadTeacher']) {
              echo 'head teacher.';
            } elseif ($PData['isInde']) {
              echo 'independent.';
            }
          } else {
            echo ": you are not allowed to see that";
          }
        ?></br>
        Groups : <?php
          if (in_array(6, $PermArray) || in_array(0, $PermArray)) {
            if (!empty($GUArray)) {
              foreach ($GUArray as $key => $value) {
                echo '<a href="search.php?g=1&gID=' . $key . '">' . $value . '</a>';
              }
            } else {
              echo "they do not belong to any group";
            }
          } else {
            echo "you are not allowed to see that";
          }
        ?>
      </p>
    </section>
    <?php
      } else {
        ?>
          <section class="warn">
            <h1>WARNING!</h1>
            <p>You are not allowed to see that profile page!</p>
          </section>
        <?php
      }
    }
    ?>
  </body>
</html>
