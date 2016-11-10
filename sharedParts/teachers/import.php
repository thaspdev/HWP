<?php
//Teachers
  if(isset($_SESSION['userID'])){
    $TArrayNames = array(0 => "No teacher");
    $TArrayIDs = array(0 => 0);
    $TeacherAnswer = $DB->prepare('SELECT userID, firstName, lastName FROM users WHERE isTeacher = 1 AND userID IN (SELECT userID FROM groupMembers WHERE groupID IN (SELECT groupID FROM groupMembers WHERE userID = ?))');
    $TeacherAnswer->execute(array($_SESSION['userID']));
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
  }
?>
