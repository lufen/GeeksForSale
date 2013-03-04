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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
   <HEAD>
      <TITLE>Geeks For Sale</TITLE>
      <link rel="stylesheet" type="text/css" href="StyleIndex.css"/>
   </HEAD>
   <BODY>
     <div id="header">
      <?php include("topmenu.php"); ?>

      <s>
       <form class="form-wrapper cf">
          <input type="text" placeholder="Search here..." required>
          <button type="submit">Search</button>
       </form>
    </s>
 </div>
 
 <div id="menu">
   <?php
   require_once 'menu.php';
   ?>
</div>

<div id="content">
  <a href="worker-myorders.php">Show my orders</a><br>
   <?php
   echo "<p>Orders not shipped or taken yet";
    require "db.php";
    $sql = 'SELECT * FROM orders WHERE workerID is null';
    $sth = $db->prepare ($sql);
    $sth->execute ();
    while($row = $sth->fetch()){
      $orderID = $row['id'];
      echo "<div id=order>";
      echo "<p>Order: ".$orderID."</br>";
      $sql = 'SELECT * FROM orderdetail WHERE orderID=:id';
      $sth2 = $db->prepare ($sql);
      $sth2->bindParam (':id', $orderID);
      $sth2->execute ();
      while($row2 = $sth2->fetch()){
        $sql = 'SELECT * FROM products WHERE id=:id';
        $sthPro = $db->prepare ($sql);
        $sthPro->bindParam (':id', $row2['productID']);
        $sthPro->execute ();
        $row3 = $sthPro->fetch();
        echo "</br>";
        echo "Product: ".$row2['productID']."Name: ".$row3['name']."</br>";
        echo "Qty: ".$row2['qty']." In stock: ".$row3['onStock'];
        echo "</br>";
      }
      echo '<form action="worker.php" method="post">';
      echo "<input type=\"hidden\" name=\"order\" value=".$orderID."/>";
      echo '<input type="submit" name="submit" value="Take order"></form>';
      echo "</div>";
    }
   ?>
</div>
</BODY>
</HTML>