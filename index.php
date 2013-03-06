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
   $sql = "SELECT * from products where rabatt <> 0";
   $sth = $db->prepare($sql);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
    while($row = $sth->fetch()){
    	echo "<div id=product>";
    	echo $row['name']."<br>";
  		echo "Details: ".$row['info']."<br>";
  		echo "In stock: ".$row['onStock']."<br>";  
  		echo "Discount: ".$row['rabatt']."%<br>";
  		echo "Old price: ".$row['price']."</br>";
  		echo "Price: ".intval($row['price'])*(intval($row['rabatt'])/100)."<br>";
		echo "</div>";
    }

   
   // while($row = $sth->fetch()){
          // echo "<div id=product>";
          // echo "<t1><a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a></t1></br>";
          // echo "<t3>In Stock: ".$row['onStock']."</t3></br>";
          // if(intval($row['rabatt'])!= 0){
            // echo "<t2>Price: $".intval($row['price'])*(intval($row['rabatt'])/100)."</t2>";
         // }else{
            // echo "<t2>Price: $".$row['price']."</t2>";
//           
        // }
          // echo "</div>";
   // }
   ?>
</div>
</BODY>
</HTML>
