<?php
  session_start();
  include("sharedParts/connectDB.php");
  if (isset($_POST['usernameIn']) AND isset($_POST['passwordIn']) AND isset($_POST['passwordCheckIn']) AND isset($_POST['emailIn']) AND isset($_POST['fiNameIn']) AND isset($_POST['laNameIn']) AND isset($_POST['isWhatIn']) AND ($_POST['passwordIn'] == $_POST['passwordCheckIn'])) {
    $UserConnectAnswer = $DB->prepare('SELECT username FROM users WHERE username = ?');
    $UserConnectAnswer->execute(array(htmlspecialchars($_POST['usernameIn'])));
    $UConnectTest = $UserConnectAnswer->fetch();
    if (isset($UConnectTest['username'])) {
      header('Location: signup.php?uNameNotAvail=1');
    } else {
      $isWhat = htmlspecialchars($_POST['isWhatIn']);
      if ($isWhat == "student") {
        $isStu = 1;
        $isTea = 0;
        $isSta = 0;
        $isHea = 0;
        $isInd = 0;
      } elseif ($isWhat == "teacher") {
        $isStu = 0;
        $isTea = 1;
        $isSta = 0;
        $isHea = 0;
        $isInd = 0;
      } elseif ($isWhat == "staff") {
        $isStu = 0;
        $isTea = 0;
        $isSta = 1;
        $isHea = 0;
        $isInd = 0;
      } elseif ($isWhat == "head") {
        $isStu = 0;
        $isTea = 0;
        $isSta = 0;
        $isHea = 1;
        $isInd = 0;
      } elseif ($isWhat == "inde") {
        $isStu = 0;
        $isTea = 0;
        $isSta = 0;
        $isHea = 0;
        $isInd = 1;
      }
      $salt = hash('sha512', mcrypt_create_iv(10));
      $hash = hash('sha512', $salt . $_POST['passwordIn']);
      $UserRegQuery = $DB->prepare('INSERT INTO users(username, hash, salt, email, firstName, lastName, isStudent, isTeacher, isStaff, isHeadTeacher, isInde) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
      $UserRegQuery->execute(array(htmlspecialchars($_POST['usernameIn']), $hash, $salt, htmlspecialchars($_POST['emailIn']), htmlspecialchars($_POST['fiNameIn']), htmlspecialchars($_POST['laNameIn']), $isStu, $isTea, $isSta, $isHea, $isInd));
      $UserConnectAnswer2 = $DB->prepare('SELECT * FROM users WHERE username = ?');
      $UserConnectAnswer2->execute(array(htmlspecialchars($_POST['usernameIn'])));
      $UConnectTest2 = $UserConnectAnswer2->fetch();
      $_SESSION['userID']=(int)$UConnectTest2['userID'];
      $_SESSION['username']=$UConnectTest2['username'];
      $_SESSION['email']=$UConnectTest2['email'];
      $_SESSION['firstName']=$UConnectTest2['firstName'];
      $_SESSION['lastName']=$UConnectTest2['lastName'];
      $_SESSION['groupID']=$UConnectTest2['groupID'];
      if ($isStu == 1) {
        $_SESSION['regType'] = "student";
      } else if ($isTea == 1) {
        $_SESSION['regType'] = "teacher";
      } else if ($isSta == 1) {
        $_SESSION['regType'] = "staff";
      } else if ($isHea == 1) {
        $_SESSION['regType'] = "head";
      } else if ($isInd == 1) {
        $_SESSION['regType'] = "inde";
        header('Location: index.php');
      }
      header('Location: registerConfirm.php');
    }
  } else {
    header('Location: signup.php?uncomplete=1');
  }
?>
