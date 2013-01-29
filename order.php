<?php
require_once 'sessionStart.php';
require_once 'db.php';
// Check if this is an update of the shoppingbasket, and modify the amounts.
 if(isset($_POST['placed'])){
 	$sql = 'INSERT INTO orders (userID)VALUES (:userID)';
  	$sth = $db->prepare ($sql);
  	$sth->bindValue (':userID', $_SESSION['id']);
  	$sth->execute ();
  	// Get ID of last insert
  	$orderID = $db->lastInsertId();
  	$ordersplaced = 0;
  	$shouldHaveBeenDone = 0;
 	 foreach ($_SESSION as $key => $quantity){
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
 	 if($ordersplaced === $shouldHaveBeenDone)
 	 	echo "Thanks for the order. It will be shipped soon";
 	 else{
 	 	echo $ordersplaced;
 	 	echo $shouldHaveBeenDone;
 	 }
	// Empty shopping basket and return to shopping basket page
	session_unset();
    //header("shoppingbasket.php");
  }?>

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
	   </div>
   </BODY>
</HTML>
