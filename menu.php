<?php
require "db.php";
	 // Get main categories
$sql = "Select * from productcategory";
$sth = $db->prepare($sql);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);  
while($row = $sth->fetch()){
	echo "<br><t1>".$row['categoryName']."</t1><br>";
		// Get subcategories
	$sql = "Select * from subcategory where categoryid = ".$row['id'];
	$sth2 = $db->prepare($sql);
	$sth2->execute();
	$sth2->setFetchMode(PDO::FETCH_ASSOC);
	while($rows = $sth2->fetch()){
		echo "<t2I><a href=\"productcategory.php?id=".$rows['id']."\">".$rows['name']."</a></t2I><br>";
	}
}
?>