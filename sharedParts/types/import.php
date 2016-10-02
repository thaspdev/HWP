<?php
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
  $TypeAnswer = $DB->prepare('SELECT * FROM types');
  $TypeAnswer->execute();
  while($TypeData = $TypeAnswer->fetch()) {
    $TypeArrayNames[$TypeData['typeID']] = $TypeData['typeName'];
    $TypeArrayDurations[$TypeData['typeID']] = $TypeData['estimatedDuration'];
  }
?>
