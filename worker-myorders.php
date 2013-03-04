<?php
require 'user.php';

CheckIfWorkerLoggedIn();
function MyOrderNotShippedYet(){
  require 'db.php';
    // Find all orders that I own that are not yet shipped
  $sql = 'SELECT * FROM orders WHERE workerID =:id AND shipped = 0';
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
    echo "<input type=\"hidden\" name=\"order\" value=".$orderID." />";
    echo '<input type="submit" name="submit" value="Ship"></form>';
    echo "</div>";
  }
}
function SendOrder(){
// Mark order as shipped
  require 'db.php';
  try{
    $db->beginTransaction();
    
    // Set each orderline as shipped
    $db->exec('LOCK TABLES orderdetail WRITE');
    $sql = 'select lineID,productID,qty from orderdetail where orderID=:id';
    $sthLine = $db->prepare ($sql);
    $sthLine->bindParam (':id', $_POST['order']);
    $sthLine->execute ();
    
    while($row = $sthLine->fetch()){
      // Mark orderline as sent
      $sql = 'Update orderdetail set sendt=1 where lineID=:lineID';
      $tmpSTH = $db->prepare ($sql);
      $tmpSTH->bindParam (':lineID', $row['lineID']);
      $db->exec('LOCK TABLES orderdetail WRITE');
      $tmpSTH->execute ();

      // Get old amount
      $db->exec('LOCK TABLES products WRITE');
      $sql = 'select onStock from products where id=:id';
      $tmpProd = $db->prepare ($sql);
      $tmpProd->bindParam (':id', $row['productID']);
      $tmpProd->execute ();
      $tmpRow = $tmpProd->fetch();

      // If not enough in stock, then rollback
      if($tmpRow['onStock'] < $row['qty']){
        $db->rollBack();
        throw new Exception('Not enough in stock');  
      }

      // Mark order as shipped
      $db->exec('LOCK TABLES orders WRITE');
      $sql = 'UPDATE orders set shipped=1 where id=:orderID';
      $sthOrder = $db->prepare ($sql);
      $sthOrder->bindParam (':orderID', $_POST['order']);
      $db->exec('LOCK TABLES orders WRITE');
      $sthOrder->execute();
      $rowsChanged =  $sthOrder->rowCount();
      if($rowsChanged != 1){
        $db->rollBack();
        throw new Exception('Order not found');  
      }

      // Update amount of each product in stock
      $db->exec('LOCK TABLES products WRITE');
      $sql = 'Update products set onStock=:qtyLeft where id=:productID';
      $updateSTH = $db->prepare ($sql);
      $updateSTH->bindParam (':productID', $row['productID']);
      $left =  intval($tmpRow['onStock']) - intval($row['qty']);
      $updateSTH->bindParam (':qtyLeft',$left);
      $updateSTH->execute ();
    }
    $db->commit();
    $db->exec('UNLOCK TABLES');
  }
  catch(Exception $e){
    return $e->getMessage();
    $db->query ('UNLOCK TABLES');
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
 echo "</br>";
  if (isset ($_POST['order'])) {
  echo SendOrder();
}

 MyOrderNotShippedYet();

?>
</div>
</BODY>
</HTML>