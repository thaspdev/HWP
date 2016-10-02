<?php
//Teachers
  $UArrayNames = [];
  $UArrayIDs = [];
  $UserAnswer = $DB->prepare('SELECT userID, username FROM users');
  $UserAnswer->execute();
  while($UData = $UserAnswer->fetch()) {
    $UArrayNames[$UData['userID']] = $UData['username'];
    $UArrayIDs[$UData['username']] = $UData['userID'];
  }
?>
