<?php
require 'user.php';
CheckIfUserLoggedIn();
// Find all orders for a user, and all products in that order. Put into a div of their own.
function FindOrders(){
  require 'sessionStart.php';
  require 'db.php';
  $shipped = 0;
  if(isset($_GET['shipped'])){
    if(intval($_GET['shipped']) === 1){
     $shipped = 1;
   }else{
    $shipped = 0;
  }
}
$sql = 'select * from orders where userID = :id';
$sth = $db->prepare($sql);
$sth->bindValue (':id', $_SESSION['id']);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
    // only add if we only found one category
while($row = $sth->fetch()){
    // Only show the orders wanted
  if($shipped == 1 && intval($row['shipped']) != 1)
    continue;
  else if($shipped == 0 && intval($row['shipped']) != 0)
    continue;

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
   echo " price: $".$row2['price'];
   echo " Shipped: ";
   if(intval($row2['sendt']) === 0){
    echo "Not shipped";
  }else{
    echo "Shipped";
  }

  $price += (intval($row2['price']) * intval($row2['qty'])); 
  echo "</br>";
}
echo "</br>Total price: $".$price."</br>";

if(intval($row['shipped']) === 0){
  echo'<form method="post" action="mypage-orders.php">';
  echo "<input type=\"hidden\" name=\"orderID\" value=".$orderID."/>";
  echo '<input type="submit" value="delete"/>';
}

echo "</div>";
}
}

function deleteOrder(){
  require 'db.php';
  // Delete from orders
  $sql = 'delete from orders where id = :id';
  $sth = $db->prepare($sql);
  $sth->bindValue (':id', $_POST['orderID']);
  $sth->execute();
  // Delete from orderdetails
  $sql = 'delete from orderdetail where orderID = :id';
  $sth = $db->prepare($sql);
  $sth->bindValue (':id', $_POST['orderID']);
  $sth->execute();
}
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
  <?php include 'mypage-buttons.php'; ?>
  <?php			
  if(isset($_POST['orderID'])){
    deleteOrder();
  }
  FindOrders();

  ?>
</div>
</BODY>
</HTML>