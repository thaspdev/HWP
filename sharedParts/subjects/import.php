<?php
  include_once('sharedParts/groups/import.php');
  $Groups__subjects = $GUArray;
  unset($Groups__subjects[0]);
  $GSstr__ = join("', '",$Groups__subjects);
  $SubArrayNames = array(0 => "No subject");
  $SubAnswer = $DB->prepare('SELECT * FROM subjects WHERE userID = ? OR groupID IN ?');
  $SubAnswer->execute(array($_SESSION['userID'], $GSstr__));
  while($SubData = $SubAnswer->fetch()) {
    $SubArrayNames[$SubData['subjectID']] = $SubData['subjectName'];
  }
?>
