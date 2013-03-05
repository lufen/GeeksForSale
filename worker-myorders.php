<?php
require 'user.php';

CheckIfWorkerLoggedIn();
function MyOrderNotShippedYet(){
  require 'worker-common.php';
    // Find all orders that I own that are not yet shipped
  $sql = 'SELECT * FROM orders WHERE workerID =:id AND shipped = 0';
  commonWorkerSearch($sql,1); 
}
function SendOrder(){
// Mark order as shipped
  require 'db.php';
  try{
    $db->beginTransaction();
    
    // Get all orderlines
    $db->exec('LOCK TABLES orderdetail WRITE');
    $sql = 'select lineID,productID,qty from orderdetail where orderID=:id';
    $sthLine = $db->prepare ($sql);
    $sthLine->bindParam (':id', $_POST['order']);
    $sthLine->execute ();
    
    while($row = $sthLine->fetch()){
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

      // Update amount of each product in stock
      $db->exec('LOCK TABLES products WRITE');
      $sql = 'UPDATE products set onStock=:qtyLeft where id=:productID';
      $updateSTH = $db->prepare ($sql);
      $updateSTH->bindParam (':productID', $row['productID']);
      $left =  intval($tmpRow['onStock']) - intval($row['qty']);
      $updateSTH->bindParam (':qtyLeft',$left);
      $updateSTH->execute ();

      // Mark orderline as sent
      $sql = 'Update orderdetail set sendt=1 where lineID=:lineID';
      $tmpSTH = $db->prepare ($sql);
      $tmpSTH->bindParam (':lineID', $row['lineID']);
      $db->exec('LOCK TABLES orderdetail WRITE');
      $tmpSTH->execute ();

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
    }
    $db->commit();
    header( 'Location: worker-myorders.php' );
  }
  catch(Exception $e){
    return $e->getMessage();
    $db->rollBack();
    $db->query ('UNLOCK TABLES');
    throw new Exception('Something whent wrong, Not enough in stock');  
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