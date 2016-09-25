<?php
try {
  $DB = new PDO('mysql:host=localhost;dbname=HWP_DB;charset=utf8','root','');
} catch (Exception $e) {
  die('Error : ' . $e->getMessage());
}
?>
