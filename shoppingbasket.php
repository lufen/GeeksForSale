<?php
require_once 'user.php';
require_once 'sessionStart.php';

// Check if this is an update of the shoppingbasket, and modify the amounts.
if(isset($_GET["hidden"])){
  foreach($_GET as $key => $qty){
    if($qty == 0){
      unset($_SESSION[$key]);
    }else{
      $_SESSION[$key] = $qty;
    }
  }
} else if(isset($_GET['deleteContent'])){
  emptyBasket();
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
 <?php require_once 'menu.php'; ?>
</div>
<div id="content">
  <form method="get" action="shoppingbasket.php">
    <input type="hidden" name="hidden" value="1"/>
    <?php 
    echo "<t0>Shopping cart</t0></br>";
    $cartPrice = 0;
    foreach ($_SESSION as $key => $quantity){
      if($quantity < 0)
        $quantity = 0;
      $sql = "Select name,price,rabatt from products where id=:id";
      $sth = $db->prepare($sql);
      $sth->bindValue (':id', substr($key,1));
      $sth->execute();
      $sth->setFetchMode(PDO::FETCH_ASSOC);  
      // Print out each row in the basket
      while($row = $sth->fetch()){
        if(intval($row['rabatt']) != 0)
          $price = intval($row['price'])*(intval($row['rabatt'])/100);
        else
          $price = $row['price'];
        echo "<t2>Name: </t2>".$row['name']."</br> <t2>Price per: </t2>$".$price." <t2>Qty: </t2>";
        echo "<input type=\"number\" name=\"$key\" value=$quantity min=\"0\"/> ";
        $linePrice = $price*$quantity;
        $cartPrice +=$linePrice;
        echo "<t2>Sub Total: </t2>$".$linePrice;
        echo "<br>";
      }
    }
    echo "<br>";
    echo "<t1>Total price: </t1>$".$cartPrice."<br>";
    ?>
    <input type="submit" value="Change quantities"/>
  </form>
  <?php 
  if(isset($_SESSION['id'])){
  echo '<form action="order.php" method="post">
   <input type="hidden" name="placed" value="1"/>
   <input type="submit" name="submit" value="Buy">
 </form>';
}
?>
 <form action="shoppingbasket.php" method="get">
  <input type="hidden" name="deleteContent" value="1"/>
  <input type="submit" name="submit" value="Empty basket">
</form>


</div>
</BODY>
</HTML>
