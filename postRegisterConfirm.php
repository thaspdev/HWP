<?php
  session_start();
  include('sharedParts/connectDB.php');
  if (isset($_SESSION['userID']) AND isset($_SESSION['regType'])) {
    if (isset($_POST['teacherIDIn'])) {
      include("sharedParts/teachers/teachersID-NameImport.php");
      if (in_array($_POST['teacherIDIn'], $TArrayIDs)) {
        $TeacherAnswer = $DB->prepare('INSERT INTO requests(fromID, toID, status) VALUES (?,?,0)');
        $TeacherAnswer->execute(array($_SESSION['userID'], $_POST['teacherIDIn']));
        $TeaAnswer = $DB->prepare('SELECT email FROM users WHERE isTeacher = 1 AND userID = ?');
        $TeaAnswer->execute(array($_POST['teacherIDIn']));
        while ($TeaData = $TeacherAnswer->fetch()) {
          mail($TeaData['email'], "HWP - New request from a student", $_SESSION['username'] . "(" . $_SESSION['firstName'] . "" . $_SESSION['lastName'] . " wants to be part of a group you're involved in. If you accept this request, the student will have access to all the features concerning this group. Please log into your HWP account to accept or decline this request.");
        }
      } else {
        header('Location: registerConfirm.php');
      }
    }
  } else {
    header('Location: registerConfirm.php');
  }
 ?>
