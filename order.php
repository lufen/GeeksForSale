<?php
// Returns NULL on order placed, else returns 1
function OrderPlaced(){
  require 'sessionStart.php';
  require 'db.php';
  require 'user.php';
  $sql = 'INSERT INTO orders (userID,workerID,shipped)VALUES (:userID,:workerID,:shipped)';
  $sth = $db->prepare ($sql);
  $sth->bindValue (':userID', $_SESSION['id']);
  $sth->bindValue (':workerID',null);
  $sth->bindValue (':shipped',0);
  $sth->execute ();
	// Get ID of last insert
  $orderID = $db->lastInsertId();
  $ordersplaced = 0;
  $shouldHaveBeenDone = 0;
  foreach ($_SESSION as $key => $quantity){
    if((substr($key,0,1) != "p"))
      continue;
    $shouldHaveBeenDone++;

		// Get price from DB
    $sqltmp = 'Select * from products where id = :id';
    $sthTmp = $db->prepare ($sqltmp);
    $sthTmp->bindValue(':id',substr($key,1));
    $sthTmp->execute ();
    $sthTmp->setFetchMode(PDO::FETCH_ASSOC);  
    $row = $sthTmp->fetch();
    if(intval($row['rabatt']) != 0)
      $price = intval($row['price'])*(intval($row['rabatt'])/100);
    else
      $price = $row['price'];

    $sql = 'INSERT INTO orderdetail (orderID, productID, price, qty, sendt)VALUES (:orderID, :productID, :price, :qty, :sendt)';
    $sth = $db->prepare ($sql);
    $sth->bindValue (':orderID', $orderID);
    $sth->bindValue (':productID', substr($key,1));
    $sth->bindValue (':price', $price);
    $sth->bindValue (':qty', $quantity);
    $sth->bindValue (':sendt', "0");
    $ordersplaced += $sth->execute ();
  }
  if($ordersplaced === $shouldHaveBeenDone && $shouldHaveBeenDone != 0){
    emptyBasket();
  }else{
    throw new Exception(' Order not placed, something went wrong');
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