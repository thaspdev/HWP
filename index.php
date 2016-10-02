<?php
  session_start();
  include("sharedParts/connectDB.php");
  include("sharedParts/teachers/teachersID-NameImport.php");
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
          <th>On time?</th>
        </tr>
          <?php
          /*QUERY*/
          if (isset($_SESSION['userID'])) {
            $HWListAnswer = $DB->prepare('SELECT * FROM homeworkList WHERE (userID = ? OR groupID = ?) AND percentageDone <> \'100\' ORDER BY deadline, percentageDone');
            $HWListAnswer->execute(array(htmlspecialchars($_SESSION['userID']), $_SESSION['groupID']));
            while ($HWListData = $HWListAnswer->fetch())
            {
          ?>
          <tr <?php
          echo 'onclick="document.location = \'homework.php?id=' . $HWListData['ID'] . '\';"';
          if ($HWListData['deadline']-1<=time())
            echo 'class="urgent"';
          ?>>
            <td><?php echo $HWListData['deadline']; ?></td>
            <td><?php echo $HWListData['name']; ?></td>
            <td><?php echo $HWListData['subject']; ?></td>
            <td class="notMobile"><?php echo $HWListData['type']; ?></td>
            <td class="notMobile"><?php echo $HWListData['description']; ?></td>
            <td class="notMobile"><?php echo $HWListData['groupID']; ?></td>
            <td class="notMobile"><?php echo $TArrayNames[$HWListData['teacherID']]; ?></td>
            <td class="notMobile"><?php echo $HWListData['userID']; ?></td>
            <td class="notMobile"><?php echo $HWListData['dateadded']; ?></td>
            <td><?php echo $HWListData['estimatedDuration']; ?></td>
            <td <?php
            if ($HWListData['percentageDone']>=$HWListData['estimatedPercentage'])
              echo 'class="onTime"';
            else
              echo 'class="late"';
            ?>><?php echo $HWListData['percentageDone'].'%/'.$HWListData['estimatedPercentage'].'%'; ?></td>
          </tr>
          <?php
          }
          $HWListAnswer->closeCursor();
        }
          ?>
      </table>
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
        <p class="notConn">HWP was designed by a procrastinator, for procrastinators ;
           in order for them to get rid of this bad habit that most of the time
           makes people really stressful. And there are several ways it can do it.
            Indeed, its homework management system (HMS) allows you to get instant
            access to your to-do tasks, and plans your amount of work in advance,
            so that you can keep organized and beat your procrastination!
        </p>
      </section>
    <?php } ?>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>