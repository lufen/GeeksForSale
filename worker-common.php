<?php
function commonWorkerSearch($sql,$ship=0){
	require 'db.php';
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
		$gotWhatWeNeed = 1;
		while($row2 = $sth2->fetch()){
			$sql = 'SELECT * FROM products WHERE id=:id';
			$sthPro = $db->prepare ($sql);
			$sthPro->bindParam (':id', $row2['productID']);
			$sthPro->execute ();
			$row3 = $sthPro->fetch();
			echo "</br>";
			echo "Product ID: ".$row2['productID']."</br>Name: ".$row3['name']."</br>";
			echo "Qty: ".$row2['qty']." In stock: ".$row3['onStock'];
			echo "</br>";
        	// Any of the products that there is not enough of 
			if(intval($row2['qty']) > intval($row3['onStock'])){
				$gotWhatWeNeed = 0;
			}
		}
     	// Only allow to take an order if there is enough on stock
		if($gotWhatWeNeed != 0 && $ship != 1){
			echo '<form action="worker.php" method="post">';
			echo "<input type=\"hidden\" name=\"order\" value=".$orderID."/>";
			echo '<input type="submit" name="submit" value="Take order"></form>';
		}else if($gotWhatWeNeed != 0 && $ship ===1){
			echo '<form action="worker-myorders.php" method="post">';
			echo "<input type=\"hidden\" name=\"order\" value=".$orderID."/>";
			echo '<input type="submit" name="submit" value="Ship order"></form>';
		}
		echo "</div>";
	}
}
?>