<?php
// Returns NULL on order placed, else returns 1
function OrderPlaced(){
  require 'sessionStart.php';
  require 'db.php';
  require 'user.php';
  $sql = 'INSERT INTO orders (userID)VALUES (:userID)';
  $sth = $db->prepare ($sql);
  $sth->bindValue (':userID', $_SESSION['id']);
  $sth->execute ();
  	// Get ID of last insert
  $orderID = $db->lastInsertId();
  $ordersplaced = 0;
  $shouldHaveBeenDone = 0;
  foreach ($_SESSION as $key => $quantity){
    if($key ==="id"|| $key === "userLevel" || $key === "hidden")
      continue;
    $shouldHaveBeenDone++;
		// Get price from DB
    $sqltmp = 'Select * from products where id = :id';
    $sthTmp = $db->prepare ($sqltmp);
    $sthTmp->bindValue(':id',substr($key,1));
    $sthTmp->execute ();
    $sthTmp->setFetchMode(PDO::FETCH_ASSOC);  
    $row = $sthTmp->fetch();
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
    return NULL;
    emptyBasket();
  }else{
    return 1;
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
 if(isset($_POST['placed'])){
  if(OrderPlaced() === NULL){
    echo "<p> Thanks for your order";
  }else{
    echo "Order failed, code monkeys working on it";
  }
}

?>
</div>
</BODY>
</HTML>
