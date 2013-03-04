<?php
// Returns NULL on order placed, else returns 1
function FindOrders(){
  require 'sessionStart.php';
  require 'db.php';
  
  $sql = 'select id from orders where userID = :id';
  $sth = $db->prepare($sql);
  $sth->bindValue (':id', $_SESSION['id']);
  $sth->execute();
  $sth->setFetchMode(PDO::FETCH_ASSOC);
    // only add if we only found one category
  while($row = $sth->fetch()){
    $price = 0;
    $orderID = $row['id'];
   echo "<div id=order>";
   echo "<p>Order: ".$orderID."</br>";
   // Find details of order
   $sql2 = 'select * from orderdetail where orderID = :id';
   $sth2 = $db->prepare($sql2);
   $sth2->bindValue (':id', $orderID);
   $sth2->execute();
   $sth2->setFetchMode(PDO::FETCH_ASSOC);
   while($row2 = $sth2->fetch()){
     $sqlPro = 'select name from products where id = :id';
     $sthPro = $db->prepare($sqlPro);
     $sthPro->bindValue (':id', $row2['productID']);
     $sthPro->execute();
     $sthPro->setFetchMode(PDO::FETCH_ASSOC);
     $rowPro = $sthPro->fetch();
     echo "Product: <a href=\"productdetails.php?id=".$row2['productID']."\">".$rowPro['name']."</a><br>";
     echo " qty: ".$row2['qty'];
     echo " price: ".$row2['price'];
     echo " Shipped: ".$row2['sendt'];    
     $price += (intval($row2['price']) * intval($row2['qty'])); 
   }
   echo "</br>Total price: ".$price." USD";
   echo "</div>";
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
  <h1>
   <?php
   echo "Geeks for sale!!!";
   ?>
 </h1>
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
 echo "I am a user, I want to see my orders you damn";
 FindOrders();
 ?>
</div>
</BODY>

</HTML>