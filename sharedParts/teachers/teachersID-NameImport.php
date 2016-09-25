<?php
//Teachers
  $TArrayNames = [];
  $TArrayIDs = [];
  $TeacherAnswer = $DB->prepare('SELECT userID, firstName, lastName FROM users WHERE isTeacher = 1');
  $TeacherAnswer->execute();
  while($TData = $TeacherAnswer->fetch()) {
    $TArrayNames[$TData['userID']] = $TData['firstName'] . " " . $TData['lastName'];
    $TArrayIDs[$TData['firstName'] . " " . $TData['lastName']] = $TData['userID'];
  }
?>
