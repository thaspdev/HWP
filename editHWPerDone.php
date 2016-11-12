<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (isset($_SESSION['userID']) AND isset($_POST['HWID']) AND isset($_POST['percentageDone']) AND 0 <= $_POST['percentageDone'] AND 100 >= $_POST['percentageDone']) {
    $HWDoneAnswer = $DB->preapre("SELECT hwDoneID FROM homeworkDone WHERE userID = ? AND hwListID = ?");
    $HWDoneAnswer->execute(array($_SESSION['userID'], $_POST['HWID']));
    $HWData = $HWDoneAnswer->fetch();
    if (!$HWData) {
      header("Location: index.php?invalidAction=1");
    } else {
      $HWDoneUpdate = $DB->prepare("UPDATE homeworkDone SET percentageDone = ? WHERE userID = ? AND hwListID = ?");
      $HWDoneUpdate->execute(array($_POST["percentageDone"],$_SESSION['userID'], $_POST['HWID']));
    }
  } else {
    header("Location: index.php?invalidAction=1");
  }
?>
