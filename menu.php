<?php
require_once "db.php";
 // Get main categories
 $sql = "Select * from productcategory";
 $sth = $db->prepare($sql);
 $sth->execute();
 $sth->setFetchMode(PDO::FETCH_ASSOC);  
 echo "<br>";
 while($row = $sth->fetch()){
 	echo $row['categoryName'];
	// Get subcategories
	$sql = "Select * from subcategory where categoryid = ".$row['id'];
	$sth2 = $db->prepare($sql);
	$sth2->execute();
  	$sth2->setFetchMode(PDO::FETCH_ASSOC);
	while($rows = $sth2->fetch()){
		echo "<br>";
	    echo "<a href=\"productcategory.php?id=".$rows['id']."\">".$rows['name']."</a><br>";
	}
 }
?>