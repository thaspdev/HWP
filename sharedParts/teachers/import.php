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
  $NUTeacherAnswer = $DB->prepare('SELECT teacherID, firstName, lastName FROM nonUserTeachers');
  $NUTeacherAnswer->execute();
  while($NUTData = $NUTeacherAnswer->fetch()) {
    $TArrayNames[(-1)*$NUTData['teacherID']] = $NUTData['firstName'] . " " . $NUTData['lastName'];
    $TArrayIDs[$NUTData['firstName'] . " " . $NUTData['lastName']] = (-1)*$NUTData['teacherID'];
  }
?>
