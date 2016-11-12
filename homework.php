<?php
  session_start();
  include("sharedParts/connectDB.php");
  include("sharedParts/teachers/import.php");
  include("sharedParts/users/import.php");
  include("sharedParts/subjects/import.php");
  include("sharedParts/types/import.php");
  include("sharedParts/groups/import.php");
  if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
  }
?>
<?php
  $HWAnswer = $DB->prepare('SELECT *, DATE_FORMAT(deadline, \'%d/%m/%y\') as deadlineVisible, DATE_FORMAT(dateadded, \'%d/%m/%y\') as dateaddedVisible FROM homeworkList WHERE ID = ?');
  $HWAnswer->execute(array(htmlspecialchars($_GET['id'])));
  $HWData = $HWAnswer->fetch();
  $HWDoneAnswer = $DB->prepare('SELECT * FROM homeworkDone WHERE hwListID = ? AND userID = ?');
  $HWDoneAnswer->execute(array($HWData['ID'], $_SESSION['userID']));
  $HWDoneData = $HWDoneAnswer->fetch();
  if (!$HWDoneData) {
    header('Location: index.php');
  }
  if (strtotime(date('d-m-Y',strtotime($HWData['deadline'])))<=time()) {
    $estimatedPercentage = 100;
  }else {
    $estimatedPercentage = round(((strtotime(date('d-m-Y', time()+86400))+((int)date('H',strtotime($HWData['deadline'])))*3600+((int)date('i',strtotime($HWData['deadline'])))*60+((int)date('s',strtotime($HWData['deadline']))) - strtotime($HWData['dateadded']))/(strtotime($HWData['deadline']) - strtotime($HWData['dateadded'])))*10000)/100;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include("sharedParts/head.php");?>
    <title><?php echo ucfirst($HWData['name']); ?> - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php");?>
    <section id="homeworkDetails">
      <h2><?php echo $HWData['name']. ' - ' . $HWData['deadlineVisible']; ?></h2>
      <p id="hwFirstPart">
      Name : <a href="search.php?hw=true&name=<?php echo $HWData['name'];?>"><?php echo $HWData['name']; ?></a></br></br>
      Deadline : <a href="search.php?hw=true&deadline=<?php echo $HWData['deadline'];?>"><?php echo $HWData['deadline']; ?></a></br></br>
      Subject : <a href="search.php?hw=true&subject=<?php echo $HWData['subjectID'];?>"><?php echo $SubArrayNames[$HWData['subjectID']]; ?></a></br></br>
      Type : <a href="search.php?hw=true&type=<?php echo $HWData['typeID'];?>"><?php echo $TypeArrayNames[$HWData['typeID']]; ?></a></br></br>
      Description : <?php echo $HWData['description']; ?></br></br>
      Group : <a href="search.php?hw=true&group=<?php echo $HWData['groupID'];?>"><?php echo $GUArray[$HWData['groupID']]; ?></a></br></br>
      Teacher : <a href="search.php?hw=true&teacher=<?php echo $HWData['teacherID'];?>"><?php echo $TArrayNames[$HWData['teacherID']]; ?></a></br></br>
      Added by : <a href="search.php?hw=true&addedby=<?php echo $HWData['userID'];?>"><?php echo $UArrayNames[$HWData['userID']]; ?></a></br></br>
      Added on : <a href="search.php?hw=true&dateadded=<?php echo $HWData['dateadded'];?>"><?php echo $HWData['dateadded']; ?></a></br></br>
      Done : <a href="search.php?hw=true&percentageDone=<?php echo $HWDoneData['percentageDone'];?>"><?php echo $HWDoneData['percentageDone']; ?> %</a> <span id="editPercentageDone">EDIT</span></p>
      <form id="editPerDForm" action="editHWPerDone.php" method="post"><input type="hidden" name="HWID" value=<?php echo $_GET['id'];?>></input><input type="number" name="editPerDIn" min="0" max="100" value=<?php echo '"' . $HWDoneData['percentageDone'] . '"'; ?>></input><input id="editHWPerDBut" type="submit" name="submitBut" value="OK!"></input></form></br></br>
      <p>
      You should have done : <a href="search.php?hw=true&estimatedPercentage=<?php echo $estimatedPercentage;?>"><?php echo $estimatedPercentage; ?> %</a></br></br>
      Duration : <a href="search.php?hw=true&estimatedDuration=<?php echo $HWData['estimatedDuration'];?>"><?php echo $HWData['estimatedDuration']; ?> minutes</a></br></br>
      You still have to work for <?php echo (100-$HWDoneData['percentageDone'])*$HWData['estimatedDuration']/100; ?> minutes</a></br></br>
      </p>
    </section>
    <script type="text/javascript">
    var clicked = false;
    window.onload=function(){
      document.getElementById("add").onmouseover=function(){
        document.getElementById("addSub").style.display = "flex";
      }
      document.getElementById("addSub").onmouseover=function(){
        document.getElementById("addSub").style.display = "flex";
      }
      document.getElementById("add").onmouseout=function(){
        document.getElementById("addSub").style.display = "none";
      }
      document.getElementById("addSub").onmouseout=function(){
        document.getElementById("addSub").style.display = "none";
      }
      //USER & USERSUB
      document.getElementById("user").onmouseover=function(){
        document.getElementById("userSub").style.display = "flex";
      }
      document.getElementById("userSub").onmouseover=function(){
        document.getElementById("userSub").style.display = "flex";
      }
      document.getElementById("user").onmouseout=function(){
        document.getElementById("userSub").style.display = "none";
      }
      document.getElementById("userSub").onmouseout=function(){
        document.getElementById("userSub").style.display = "none";
      }
      //EDIT PERCENTAGE DONE
      document.getElementById("editPercentageDone").onclick=function(){
        if(!clicked) {
          document.getElementById("editPerDForm").style.display = "flex";
          document.getElementById("editPercentageDone").style.backgroundColor = "#FF389F";
          document.getElementById("editPercentageDone").style.color = "#FFF";
          clicked = true;
        } else {
          document.getElementById("editPerDForm").style.display = "none";
          document.getElementById("editPercentageDone").style.backgroundColor = "#FFF";
          document.getElementById("editPercentageDone").style.color = "#4B4B4D";
          clicked = false;
        }
      }
    }
    </script>
  </body>
</html>
