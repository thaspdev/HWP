<?php
  session_start();
  include("sharedParts/connectDB.php");
  include("sharedParts/teachers/teachersID-NameImport.php");
  include("sharedParts/users/userID-Name.php");
?>
<?php
  $HWAnswer = $DB->prepare('SELECT *, DATE_FORMAT(deadline, \'%d/%m/%y\') as deadlineVisible, DATE_FORMAT(dateadded, \'%d/%m/%y\') as dateaddedVisible FROM homeworkList WHERE ID = ?');
  $HWAnswer->execute(array(htmlspecialchars($_GET['id'])));
  $HWData = $HWAnswer->fetch();
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
      <p>
      Name : <a href="search.php?hw=true&name=<?php echo $HWData['name'];?>"><?php echo $HWData['name']; ?></a></br></br>
      Deadline : <a href="search.php?hw=true&deadline=<?php echo $HWData['deadline'];?>"><?php echo $HWData['deadlineVisible']; ?></a></br></br>
      Subject : <a href="search.php?hw=true&subject=<?php echo $HWData['subject'];?>"><?php echo $HWData['subject']; ?></a></br></br>
      Type : <a href="search.php?hw=true&type=<?php echo $HWData['type'];?>"><?php echo $HWData['type']; ?></a></br></br>
      Description : <?php echo $HWData['description']; ?></br></br>
      Group : <a href="search.php?hw=true&group=<?php echo $HWData['groupID'];?>"><?php echo $HWData['groupID']; ?></a></br></br>
      Teacher : <a href="search.php?hw=true&teacher=<?php echo $HWData['teacherID'];?>"><?php echo $TArrayNames[$HWData['teacherID']]; ?></a></br></br>
      Added by : <a href="search.php?hw=true&addedby=<?php echo $HWData['userID'];?>"><?php echo $UArrayNames[$HWData['userID']]; ?></a></br></br>
      Added on : <a href="search.php?hw=true&dateadded=<?php echo $HWData['dateadded'];?>"><?php echo $HWData['dateaddedVisible']; ?></a></br></br>
      Done : <a href="search.php?hw=true&percentageDone=<?php echo $HWData['percentageDone'];?>"><?php echo $HWData['percentageDone']; ?> %</a></br></br>
      You should have done : <a href="search.php?hw=true&estimatedPercentage=<?php echo $HWData['estimatedPercentage'];?>"><?php echo $HWData['estimatedPercentage']; ?> %</a></br></br>
      Duration : <a href="search.php?hw=true&estimatedDuration=<?php echo $HWData['estimatedDuration'];?>"><?php echo $HWData['estimatedDuration']; ?> minutes</a></br></br>
      You still have to work for <?php echo (100-$HWData['percentageDone'])*$HWData['estimatedDuration']/100; ?> minutes</a></br></br>
      </p>
    </section>
    <script type="text/javascript" src="script.js"></script>
  </body>
</html>
