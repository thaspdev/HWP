<?php
  session_start();
  include('sharedParts/connectDB.php');
  include("sharedParts/groups/import.php");
  include("sharedParts/teachers/import.php");
  include("sharedParts/subjects/import.php");
  include("sharedParts/types/import.php");
  if (isset($_POST['HWNameIn']) AND isset($_POST['descriptionIn']) AND isset($_POST['typeIn']) AND isset($_POST['durationIn']) AND ((isset($_POST['subjectIn']) AND isset($_POST['teacherIn']) AND isset($_POST['groupIn']) AND isset($_POST['deadlineDateIn']) AND isset($_POST['deadlineTimeIn'])) OR isset($_POST['sessionIn']))) {
    if (array_key_exists($_POST['typeIn'], $TypeArrayNames) AND 0 < $_POST['durationIn'] AND $_POST['durationIn'] < 65535) {
      if (isset($_POST['bySession'])) {
        header('Location: addHomework.php?sessionNotAvail=1');
      } elseif (isset($_POST['manually'])) {
        if (array_key_exists($_POST['subjectIn'], $SubArrayNames) AND array_key_exists($_POST['groupIn'], $GUArray) AND array_key_exists($_POST['teacherIn'], $TArrayNames) AND preg_match("@^(?:0[1-9]|1[0-2])/(?:0[1-9]|[1-2][0-9]|[3][0-1])/20(?:1[6-9]|2[0-9]|3[0-8])$@", $_POST['deadlineDateIn']) AND preg_match("@^(?:[0-1][0-9]|2[0-3]):[0-5][0-9]$@",$_POST['deadlineTimeIn'])) {
          $GroupAdminQuery = $DB->prepare("SELECT isAdmin FROM groupMembers WHERE userID = ? AND groupID = ?");
          $GroupAdminQuery->execute(array($_SESSION['userID'],$_POST['groupIn']));
          $GAData = $GroupAdminQuery->fetch();
          if ($GAData['isAdmin']){
            $deadline = date("Y-m-d H:i:s", strtotime(htmlspecialchars($_POST['deadlineDateIn']) . ' ' . htmlspecialchars($_POST['deadlineTimeIn']) . ':00'));
            $InsertHW = $DB->prepare('INSERT INTO homeworkList(subjectID,typeID,name,description,userID,teacherID,groupID,deadline,estimatedDuration) VALUES (?,?,?,?,?,?,?,?,?)');
            $InsertHW->execute(array(htmlspecialchars($_POST['subjectIn']),htmlspecialchars($_POST['typeIn']),htmlspecialchars($_POST['HWNameIn']), htmlspecialchars($_POST['descriptionIn']), htmlspecialchars($_SESSION['userID']), htmlspecialchars($_POST['teacherIn']), htmlspecialchars($_POST['groupIn']), $deadline, htmlspecialchars($_POST['durationIn'])));
            header("Location: index.php?HWadded=1");
          } else {
            header('Location: addHomework.php?invalidInput=1');
          }
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
