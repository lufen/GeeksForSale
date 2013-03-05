<?php
require 'user.php';
require 'db.php';
CheckIfWorkerLoggedIn();
// Give this order to the current worker
if (isset ($_POST['order'])) {
  $sql = 'Update orders set workerID=:id where id=:orderID';
  $sthPro = $db->prepare ($sql);
  $sthPro->bindParam (':id', $_SESSION['id']);
  $sthPro->bindParam (':orderID', $_POST['order']);
  $sthPro->execute ();
}
function OrderNotYetShipped(){
    require 'worker-common.php';
    $sql = 'SELECT * FROM orders WHERE workerID is null AND shipped=0';
    commonWorkerSearch($sql); 
}
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
  <button> <a href="worker-myorders.php"> My orders </a> </button>
  <button> <a href="worker.php"> Orders not taken </a> </button>
   <?php
   echo "<p>Orders not shipped or taken yet";
   OrderNotYetShipped();
   ?>
</div>
</BODY>
</HTML>