<?php
  $SubArrayNames = [];
  $SubAnswer = $DB->prepare('SELECT * FROM subjects');
  $SubAnswer->execute();
  while($SubData = $SubAnswer->fetch()) {
    $SubArrayNames[$SubData['subjectID']] = $SubData['subjectName'];
  }
?>
