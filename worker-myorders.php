<?php
require 'user.php';
require 'db.php';
CheckIfWorkerLoggedIn();
// Mark order as shipped
if (isset ($_POST['order'])) {
  $sql = 'Update orders set shipped=1 where id=:orderID';
  $sthPro = $db->prepare ($sql);
  $sthPro->bindParam (':orderID', $_POST['order']);
  $sthPro->execute ();

  // set each orderline as shipped also
  $sql = 'select productID,lineID,qty from orderdetail where orderID=:id';
  $sthLine = $db->prepare ($sql);
  $sthLine->bindParam (':id', $_POST['order']);
  $sthLine->execute ();
  while($row = $sthLine->fetch()){
    // Mark orderline as sent
    $sql = 'Update orderdetail set sendt=1 where lineID=:lineID';
    $tmpSTH = $db->prepare ($sql);
    $tmpSTH->bindParam (':lineID', $row['lineID']);
    $tmpSTH->execute ();

    // Get old amount
    $sql = 'select onStock from products where id=:id';
    $tmpProd = $db->prepare ($sql);
    $tmpProd->bindParam (':id', $row['productID']);
    $tmpProd->execute ();
    $tmpRow = $tmpProd->fetch();
    
    // Update amount of each product in stock
    $sql = 'Update products set onStock=:qtyLeft where id=:productID';
    $updateSTH = $db->prepare ($sql);
    $updateSTH->bindParam (':productID', $row['productID']);
    $left =  $tmpRow['onStock'] - $row['qty'];
    $updateSTH->bindParam (':qtyLeft',$left);
    $updateSTH->execute ();
  }
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
   <?php
   echo "<p>My orders not shipped or taken yet";
    require "db.php";
    $sql = 'SELECT * FROM orders WHERE workerID=:id AND shipped = 0';
    $sth = $db->prepare ($sql);
    $sth->bindParam (':id', $_SESSION['id']);
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
      echo '<form action="worker-myorders.php" method="post">';
      echo "<input type=\"hidden\" name=\"order\" value=".$orderID."/>";
      echo '<input type="submit" name="submit" value="Ship"></form>';
      echo "</div>";
    }
   ?>
</div>
</BODY>
</HTML>