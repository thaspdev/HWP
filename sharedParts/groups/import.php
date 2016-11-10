<?php
  if (isset($_SESSION['userID'])) {
    $GUArray = array(0 => "No group");
    $MainGUArray = [];
    $GUIDArray = array(0 => 0);
    $MainGUIDArray = [];
    $GroupsUserAnswer = $DB->prepare('SELECT * FROM groups WHERE groupID IN (SELECT groupID FROM groupMembers WHERE userID = ?)');
    $GroupsUserAnswer->execute(array(htmlspecialchars($_SESSION['userID'])));
    while($GroupsUserData = $GroupsUserAnswer->fetch())
    {
      $GUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
      if($GroupsUserData['isMainGroup']) {
        $MainGUArray[$GroupsUserData['groupID']] = $GroupsUserData['groupName'];
      }// Makes groups' IDs correspond to their names
      $GUIDArray[$GroupsUserData['groupID']] = $GroupsUserData['groupID'];
      if($GroupsUserData['isMainGroup']) {
        $MainGUIDArray[$GroupsUserData['groupID']] = $GroupsUserData['groupID'];
      }//A list of all the IDs of the user's groups
    }
  }
?>
