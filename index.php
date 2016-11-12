<?php
  session_start();
  include("sharedParts/connectDB.php");
  include("sharedParts/teachers/import.php");
  include("sharedParts/users/import.php");
  include("sharedParts/subjects/import.php");
  include("sharedParts/types/import.php");
  include("sharedParts/groups/import.php");
?>
<!DOCTYPE html>
<html lang='EN'>
  <head>
    <?php include("sharedParts/head.php");?>
      <title>HWP - Homework Planner</title>
  </head>
  <body>
    <?php include("sharedParts/header.php");
      if (isset($_SESSION['userID'])) {
    ?>
    <section id="todo">
      <h2>TO DO</h2>
      <table>
        <tr>
          <th>Deadline</th>
          <th>Name</th>
          <th>Subject</th>
          <th class="notMobile">Type</th>
          <th class="notMobile">Description</th>
          <th class="notMobile">Group</th>
          <th class="notMobile">Teacher</th>
          <th class="notMobile">User</th>
          <th class="notMobile">Added on</th>
          <th>Duration</th>
          <th>To work</th>
          <th>On time?</th>
        </tr>
          <?php
          /*QUERY*/
          if (isset($_SESSION['userID'])) {
            $GArrayHW__ = $GUArray;
            unset($GArrayHW__[0]);
            $GstrHW__ = implode(",",$GArrayHW__);
            if ($GstrHW__ == "") {
              $HWListAnswer = $DB->prepare('SELECT * FROM homeworkList WHERE userID = ? ORDER BY deadline');
              $HWListAnswer->execute(array(htmlspecialchars($_SESSION['userID'])));
            } else {
              $HWListAnswer = $DB->prepare('SELECT * FROM homeworkList WHERE (userID = ? OR groupID IN (?)) ORDER BY deadline');
              $HWListAnswer->execute(array(htmlspecialchars($_SESSION['userID']), $GstrHW__));
            }
            $totalWork = 0;
            while ($HWListData = $HWListAnswer->fetch())
            {
              $HWDoneAnswer = $DB->prepare('SELECT * FROM homeworkDone WHERE hwListID = ?');
              $HWDoneAnswer->execute(array($HWListData['ID']));
              $HWDoneData = $HWDoneAnswer->fetch();
              if (!$HWDoneData){
                $HWDoneCreate = $DB->prepare("INSERT INTO homeworkDone(hwListID,userID,percentageDone) VALUES (?,?,0)");
                $HWDoneCreate->execute(array($HWListData['ID'],$_SESSION['userID']));
                $HWDoneAnswer = $DB->prepare('SELECT * FROM homeworkDone WHERE hwListID = ?');
                $HWDoneAnswer->execute(array($HWListData['ID']));
                $HWDoneData = $HWDoneAnswer->fetch();
              }
              if (isset($HWDoneData) && $HWDoneData['percentageDone'] != 100 && strtotime($HWListData['deadline'])>time()) {
                if (strtotime(date('d-m-Y',strtotime($HWListData['deadline'])))<=time()) {
                  $estimatedPercentage = 100;
                }else {
                  $estimatedPercentage = round(((strtotime(date('d-m-Y', time()+86400))+((int)date('H',strtotime($HWListData['deadline'])))*3600+((int)date('i',strtotime($HWListData['deadline'])))*60+((int)date('s',strtotime($HWListData['deadline']))) - strtotime($HWListData['dateadded']))/(strtotime($HWListData['deadline']) - strtotime($HWListData['dateadded'])))*10000)/100;
                }
                $toWork = $HWListData['estimatedDuration']*($estimatedPercentage-$HWDoneData['percentageDone'])/100;
                if ($toWork<0) {
                  $toWork = 0;
                }
                $totalWork += $toWork;
          ?>
          <tr <?php
          echo 'onclick="document.location = \'homework.php?id=' . $HWListData['ID'] . '\';"';
          if (strtotime($HWListData['deadline'])-86400<=time())
            echo 'class="urgent"';
          ?>>
            <td><?php echo $HWListData['deadline']; ?></td>
            <td><?php echo $HWListData['name']; ?></td>
            <td><?php echo $SubArrayNames[$HWListData['subjectID']]; ?></td>
            <td class="notMobile"><?php echo $TypeArrayNames[$HWListData['typeID']]; ?></td>
            <td class="notMobile"><?php echo $HWListData['description']; ?></td>
            <td class="notMobile"><?php echo $GUArray[$HWListData['groupID']]; ?></td>
            <td class="notMobile"><?php echo $TArrayNames[$HWListData['teacherID']]; ?></td>
            <td class="notMobile"><?php echo $UArrayNames[$HWListData['userID']]; ?></td>
            <td class="notMobile"><?php echo $HWListData['dateadded']; ?></td>
            <td><?php echo $HWListData['estimatedDuration']; ?></td>
            <td><?php echo $toWork; ?></td>
            <td <?php
            if ($HWDoneData['percentageDone']>=$estimatedPercentage)
              echo 'class="onTime"';
            else
              echo 'class="late"';
            ?>><?php echo $HWDoneData['percentageDone'].'%/'.$estimatedPercentage.'%'; ?></td>
          </tr>
          <?php
            }
          }
          $HWListAnswer->closeCursor();
        }
          ?>
      </table>
      <p><?php echo 'You still have to work for ' . gmdate('H',$totalWork*60) . ' h ' . gmdate('i',$totalWork*60) . ' min today.'; ?></p>
    </section>
    <section id="timetable">
      <h2>Timetable</h2>
      <table id="timetableT">
        <tr>
          <th id="mo">Monday</th>
          <th id="tu">Tuesday</th>
          <th id="we">Wednesday</th>
          <th id="th">Thursday</th>
          <th id="fr">Friday</th>
          <th id="sa">Saturday</th>
          <th id="su">Sunday</th>
        </tr>
        <?php
          while (false) {
        ?>
          <tr>
            <th class="mo"><?php ?></th>
            <th class="tu">Tuesday</th>
            <th class="we">Wednesday</th>
            <th class="th">Thursday</th>
            <th class="fr">Friday</th>
            <th class="sa">Saturday</th>
            <th class="su">Sunday</th>
          </tr>
        <?php
          }
        ?>
      </table>
    </section>
    <section id="upExams">
      <h2>Upcoming exams</h2>
    </section>
    <?php
    } else { ?>
      <section id="welcome">
        <h2>Welcome to HWP!</h2>
        <p class="notConn">You are not logged in. If you're not already a member,
          you can sign up, otherwise, you have to log in in order to see your
          content.</p>
        <div class="butDiv">
          <a href="login.php">
            <button class="signButton" id="logB">Log In</button>
          </a>
          <a href="signup.php">
            <button class="signButton" id="signB">Sign Up</button>
          </a>
        </div>
      </section>
      <section id="whatis">
        <h2>What is HWP?</h2>
        <p class="notConn">HWP is a free service that allows you to manage not only
           your homework, but also a bunch of things related to school, such as
           timetables, the students, the staff and the teachers, or the subjects.
        </p>
        <h3 class="notConnh3">How can it help you?</h3>
        <p class="notConn">HWP was designed by a procrastinator, for procrastinators,
           in order for them to get rid of this bad habit that most of the time
           makes people really stressful. And there are several ways it can help you.
            Indeed, its homework management system (HMS) allows you to get instant
            access to your to-do tasks, and plans your amount of work in advance,
            so that you can keep organized and beat your procrastination!
        </p>
      </section>
    <?php } ?>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">
    var dWClass = ["mo","tu","we","th","fr","sa","su"];
    var dWAbb = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
    var dWLong = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
    function onres(){
      if (window.innerWidth < 600) {
        for (var i = 0; i<7; i++){
          document.getElementById(dWClass[i]).innerHTML=dWAbb[i];
        }
      } else {
        for (var j = 0; j<7; j++){
          document.getElementById(dWClass[j]).innerHTML=dWLong[j];
        }
      }
    }
    window.onresize=function(){
      onres();
    }
    window.onload=function(){
      onres();
    }
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
    }
    </script>
  </body>
</html>
