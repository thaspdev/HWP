<?php
  session_start();
  include('sharedParts/connectDB.php');
  if (isset($_POST['nameIn']) AND isset($_POST['descriptionIn']) AND isset($_POST['typeIn']) AND isset($_POST['durationIn']) AND ((isset($_POST['subjectIn']) AND isset($_POST['teacherIn']) AND isset($_POST['groupIn']) AND isset($_POST['deadlineDateIn']) AND isset($_POST['deadlineTimeIn'])) OR isset($_POST['sessionIn']))) {
    if (isset($_POST['bySession'])) {
      header('Location: addHomework.php?sessionNotAvail=1');
    } elseif (isset($_POST['manually'])) {

    } else {
      header('Location: addHomework.php');
    }
  } else {
    header('Location: addHomework.php?uncomplete=1');
  }
?>
