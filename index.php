<?php
require_once 'sessionStart.php';
if(isset($_GET['logout'])){
  session_unset();
}
?>
<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
	<t0>Products on sale </t0>
   <?php
   $sql = "SELECT * from products where rabatt <>0 AND forSale=1";
   $sth = $db->prepare($sql);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
    while($row = $sth->fetch()){
    	echo "<div id=product>";
    	echo "<t1><a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a></t1></br>";
  		echo "Discount: ".$row['rabatt']."%<br>";
  		echo "Old price: ".$row['price']."</br>";
  		echo "Price: ".(intval($row['price'])*(1-(intval($row['rabatt'])/100)))."<br>";
		echo "</div>";
    }
   ?>
</div>
</BODY>
</HTML>
