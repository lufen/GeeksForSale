<?php
include 'Geeksforsaletop.php';
?>

<?php
require_once "user.php";
CheckIfAdminLoggedIn();
?>

<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
 <?php
 if(isset($_POST['placed'])){
  try { 
    OrderPlaced();
    echo "<p> Thanks for your order";
  } catch (Exception $e){
    echo $e->getMessage();
  }
}
?>
</div>
</BODY>
</HTML>