<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (isset($_SESSION['userID']) AND isset($_POST['HWID']) AND isset($_POST['editPerDIn']) AND 0 <= $_POST['editPerDIn'] AND 100 >= $_POST['editPerDIn']) {
    $HWDoneAnswer = $DB->prepare("SELECT hwDoneID FROM homeworkDone WHERE userID = ? AND hwListID = ?");
    $HWDoneAnswer->execute(array($_SESSION['userID'], $_POST['HWID']));
    $HWData = $HWDoneAnswer->fetch();
    if (!$HWData) {
      header("Location: index.php?invalidAction=1");
    } else {
      $HWDoneUpdate = $DB->prepare("UPDATE homeworkDone SET percentageDone = ? WHERE userID = ? AND hwListID = ?");
      $HWDoneUpdate->execute(array($_POST["editPerDIn"],$_SESSION['userID'], $_POST['HWID']));
      header('Location: homework.php?id=' . $_POST['HWID']);
    }
  } else {
    header("Location: index.php?invalidAction=1");
  }
?>
