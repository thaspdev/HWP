<?php
  $SubArrayNames = array(0 => "No subject");
  $SubAnswer = $DB->prepare('SELECT * FROM subjects');
  $SubAnswer->execute();
  while($SubData = $SubAnswer->fetch()) {
    $SubArrayNames[$SubData['subjectID']] = $SubData['subjectName'];
  }
?>
