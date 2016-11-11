<?php
  session_start();
  include("sharedParts/connectDB.php");
  include("sharedParts/groups/import.php");
  include("sharedParts/subjects/import.php");
  include("sharedParts/teachers/import.php");
  include("sharedParts/types/import.php");
  if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
  }
?>
<html>
  <head>
    <?php include("sharedParts/head.php");?>
    <title>Add homework - HWP</title>
  </head>
  <body>
    <?php include("sharedParts/header.php"); ?>
    <section id="addHW">
      <h1>ADD HOMEWORK</h1>
      <form action="postaddHW.php" method="post">
        <div class="subForm">
          <label for="HWNameIn">Name :</label>
          <input class="inputText" type="text" name="HWNameIn" id="HWNameIn"></input>
        </div>
        <div class="subForm">
          <label for="descriptionIn">Description :</label>
          <input class="inputText" type="text" name="descriptionIn" id="descriptionIn"></input>
        </div>
        <div class="subForm">
          <label for="typeIn">Type :</label>
          <select name="typeIn" id="typeIn">
            <?php
              foreach ($TypeArrayNames as $Typeid => $Typename) {
                ?>
                  <option value=<?php echo '"' . $Typeid . '"'; ?>><?php echo $Typename;?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="subForm">
          <label for="durationIn">Duration (in minutes) :</label>
          <input class="inputText" type="number" min="0" name="durationIn" id="durationIn"></input>
        </div>
        <div class="subForm" id="supTab">
          <div class="tabButtons">
            <div class="tabBut" id="tabButSession">By session</div>
            <div class="tabBut" id="tabButManual">Manually</div>
          </div>
          <div class="tabs">
            <div class="tab" id="sessionTab">
              <label for="sessionIn">Select a session :</label>
              <select name="sessionIn" id="sessionIn">
                <option value="" selected disabled>Please choose a session</option>
                <?php
                  foreach ($GUIDArray as $groupID => $id) {
                    $sessionsAnswer = $DB->prepare("SELECT * FROM sessions WHERE groupID = ?");
                    $sessionsAnswer->execute(array($id));?>
                    <optgroup label=""><?php
                    $sessionsArray = [];
                    while ($sessionsData = $sessionsAnswer->fetch()) {
                      $sessionsArray[$id] = $sessionsData;
                    }
                    foreach ($sessionsArray as $id => $session) {
                      ?>
                        <option value=<?php echo '"' . $id . '"'; ?>><?php echo $session; ?></option>
                      <?php
                    }
                    ?>
                    </optgroup>
                    <?php
                  }
                ?>
              </select>
              <p>Please note that if you're not an administrator of the group the session's associated with, your homework won't be added to the groups' ones. Instead, it will be associated with the group "No group", which means only you will be able to see it.</p>
              <?php if(isset($_GET['sessionNotAvail']) AND $_GET['sessionNotAvail']) {
                ?><p class="pWarn">This feature is currently not available. Please add your homework manually.</p><?php
              }?>
              <input type="submit" name="bySession" value="Add it!" class="formButton"/>
            </div>
            <div class="tab" id="manualTab">
              <label for="subjectIn">Subject :</label>
              <select name="subjectIn" id="subjectIn">
                <option value="" selected disabled>Please choose a subject</option>
                <?php foreach ($SubArrayNames as $Subid => $Subname) {
                  ?>
                    <option value=<?php echo '"' . $Subid . '"'; ?>><?php echo $Subname;?></option>
                  <?php
                } ?>
              </select>
              <label for="teacherIn">Teacher :</label>
              <select name="teacherIn" id="teacherIn">
                <option value="" selected disabled>Please choose a teacher</option>
                <?php
                  foreach ($TArrayNames as $Tid => $Tname) {
                    ?>
                      <option value=<?php echo '"' . $Tid . '"'; ?>><?php echo $Tname;?></option>
                    <?php
                  }
                ?>
              </select>
              <label for="groupIn">Group :</label>
              <select name="groupIn" id="groupIn">
                <option value="" selected disabled>Please choose a group</option>
                <?php
                  if(!empty($GUArrayMain)) {
                    ?>
                      <optgroup label="Main groups">
                    <?php
                  }
                  foreach ($GUArrayMain as $Gid => $Gname) {
                    ?>
                      <option value=<?php echo '"' . $Gid . '"'; ?>><?php echo $Gname;?></option>
                    <?php
                  }
                  if(!empty($GUArrayMain)) {
                    ?></optgroup><?php
                  }
                  if(!empty($GUArray)) {
                    ?>
                      <optgroup label="Other groups">
                    <?php
                  }
                  foreach ($GUArray as $Gid => $Gname) {
                    ?>
                      <option value=<?php echo '"' . $Gid . '"'; ?>><?php echo $Gname;?></option>
                    <?php
                  }
                  if(!empty($GUArray)) {
                    ?>
                  </optgroup>
                    <?php
                  }
                ?>
              </select>
              <label for="deadlineDateIn">Deadline (MM/DD/YYYY):</label>
              <?php if(preg_match("/Mozilla/",$_SERVER['HTTP_USER_AGENT']) AND preg_match("/Android/",$_SERVER['HTTP_USER_AGENT'])) { ?>
              <input type="text" name="deadlineDateIn" id="deadlineDateIn" class="inputText"></input>
              <?php
                } else {
              ?>
              <input type="date" name="deadlineDateIn" id="deadlineDateIn" class="inputText"></input>
              <?php
                }
              ?>
              <label for="deadlineTimeIn">Deadline (HH:MM):</label>
              <input type="time" name="deadlineTimeIn" id="deadlineTimeIn" class="inputText"></input>
              <input type="submit" name="manually" value="Add it!" class="formButton"></input>
            </div>
          </div>
        </div>
      </form>
    </section>
    <script type="text/javascript">
      var typePredefinedDurations = [];
      var typeDurations = [];
      <?php foreach ($TypeArrayDurations as $key => $duration){
        if ($key < 0) {
          ?>
            typePredefinedDurations.push(<?php
              echo $duration;
            ?>);
          <?php
        } else{
          ?>
            typeDurations.push(<?php
              echo $duration;
            ?>);
          <?php
        }
      } ?>
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
        //Tabs
        document.getElementById("tabButSession").onclick=function(){
          document.getElementById("sessionTab").style.display = "flex";
          document.getElementById("manualTab").style.display = "none";
          document.getElementById("tabButManual").style.backgroundColor = "#777";
          document.getElementById("tabButSession").style.backgroundColor = "#FF6602";
        }
        document.getElementById("tabButManual").onclick=function(){
          document.getElementById("sessionTab").style.display = "none";
          document.getElementById("manualTab").style.display = "flex";
          document.getElementById("tabButSession").style.backgroundColor = "#777";
          document.getElementById("tabButManual").style.backgroundColor = "#FF6602";
        }
        document.getElementById("typeIn").onchange=function(){
          var typeDurIndex = document.getElementById("typeIn").options[document.getElementById("typeIn").selectedIndex].value;
          if (typeDurIndex < 0) {
            typeDurIndex *= -1;
            document.getElementById("durationIn").value = typePredefinedDurations[typeDurIndex-1];
          } else {
            document.getElementById("durationIn").value = typeDurations[typeDurIndex-1];
          }
        }
      }
    </script>
  </body>
</html>
