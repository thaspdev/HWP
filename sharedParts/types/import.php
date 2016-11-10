<?php
  include_once('sharedParts/groups/import.php');
  if(isset($_SESSION['userID'])) {
    $TypeArrayNames = array(
      0 => "Generic",
      -1 => "Short exercise(s)",
      -2 => "Medium exercise(s)",
      -3 => "Long exercise(s)",
    );
    $TypeArrayDurations = array(
      -1 => 10,
      -2 => 30,
      -3 => 60,
    );
    $Groups__types = $GUArray;
    unset($Groups__types[0]);
    $GTstr__ = join("', '",$Groups__types);
    $TypeAnswer = $DB->prepare('SELECT * FROM types WHERE userID = ? OR groupID IN ?');
    $TypeAnswer->execute(array($_SESSION['userID'], $GTstr));
    while($TypeData = $TypeAnswer->fetch()) {
      $TypeArrayNames[$TypeData['typeID']] = $TypeData['typeName'];
      $TypeArrayDurations[$TypeData['typeID']] = $TypeData['estimatedDuration'];
    }
  }
?>
