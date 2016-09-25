<?php
  $StaAnswer = $DB->prepare('SELECT userID FROM users WHERE isStaff = 1 AND userID = ?');
  $StaAnswer->execute(array(htmlspecialchars()));
?>
