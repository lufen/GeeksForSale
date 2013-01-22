<?php
session_start();
// Check if this is an update of the shoppingbasket, and modify the amounts.
 if(isset($_GET)){
  foreach($_GET as $key => $qty){
    $_SESSION[$key] = $qty;
    //header("shoppingbasket.php");
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
         <?php require_once 'menu.php'; ?>
      </div>
      <div id="content">
        <form method="get" action="shoppingbasket.php">
         <?php 
           echo "Shopping cart";
           $cartPrice = 0;
           foreach ($_SESSION as $key => $quantity){
              $sql = "Select name,price from products where id=:id";
              $sth = $db->prepare($sql);
              $sth->bindValue (':id', substr($key,1));
              $sth->execute();
              $sth->setFetchMode(PDO::FETCH_ASSOC);  
              echo "<br>";

              // Print out each row in the basket
              while($row = $sth->fetch()){
                echo "<p>Name: ".$row['name']." Price: ".$row['price']." Qty: ";
                echo "<input type=\"number\" name=\"$key\" value=$quantity min=\"0\"/> ";
                $linePrice = $row['price']*$quantity;
                $cartPrice +=$linePrice;
                echo "Line: ".$linePrice;
                echo "<br>";
              }
           }
           echo "Total price: ".$cartPrice."<br>";
         ?>
         <input type="submit" value="Change quantities"/>
      </div>
   </BODY>
</HTML>
