<?php
  session_start();
  include('sharedParts/connectDB.php');
  include("sharedParts/groups/import.php");
  include("sharedParts/teachers/import.php");
  include("sharedParts/subjects/import.php");
  include("sharedParts/types/import.php");
  if (isset($_POST['nameIn']) AND isset($_POST['descriptionIn']) AND isset($_POST['typeIn']) AND isset($_POST['durationIn']) AND ((isset($_POST['subjectIn']) AND isset($_POST['teacherIn']) AND isset($_POST['groupIn']) AND isset($_POST['deadlineDateIn']) AND isset($_POST['deadlineTimeIn'])) OR isset($_POST['sessionIn']))) {
    if (array_key_exists($_POST['typeIn'], $TypeArrayNames)) {
      if (isset($_POST['bySession'])) {
        header('Location: addHomework.php?sessionNotAvail=1');
      } elseif (isset($_POST['manually'])) {
        if (array_key_exists($_POST['subjectIn'], $SubArrayNames) AND array_key_exists($_POST['groupIn'], $GUArray) AND array_key_exists($_POST['teacherIn'], $TArrayNames) AND preg_match("@^(?:0[1-9]|1[0-2])/(?:0[1-9]|[1-2][0-9]|[3][0-1])/20(?:1[6-9]|2[0-9]|3[0-8])$@", $_POST['deadlineDateIn']) AND preg_match("@^(?:[0-1][0-9]|2[0-3]):[0-5][0-9]$@"$_POST['deadlineTimeIn'])) {
          $deadline = htmlspecialchars($_POST['deadlineDateIn']) + htmlspecialchars($_POST['descriptionTimeIn']);
          $InsertHW = $DB->prepare('INSERT INTO homeworkList(subjectID,typeID,name,description,userID,teacherID,groupID,dateadded,deadline,estimatedDuration) VALUES (?,?,?,?,?,?,?,?,?,?)');
          $InsertHW->execute(array(htmlspecialchars($_POST['subjectIn']),htmlspecialchars($_POST['typeIn']),htmlspecialchars($_POST['nameIn']), htmlspecialchars($_POST['descriptionIn']), htmlspecialchars($_SESSION['userID']), htmlspecialchars($_POST['teacherIn']), htmlspecialchars($_POST['groupIn']), $deadline, htmlspecialchars($_POST['durationIn'])));
        } else {
          header('Location: addHomework.php?invalidInput=1');
        }
      } else {
        header('Location: addHomework.php');
      }
    } else {
      header('Location: addHomework.php?invalidInput=1');
    }
  } else {
    header('Location: addHomework.php?uncomplete=1');
  }
?>
