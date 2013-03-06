<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
   <?php
   $id = $_GET['id'];
   $sql = "Select * from subcategory where id=:id";
   $sth = $db->prepare($sql);
   $sth->bindValue (':id', $id);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   $row = $sth->fetch();
   echo "<t0>".$row['name']."</t0><br>";

   $sql = "Select * from products where categoriID=:id AND forSale=1";
   $sth = $db->prepare($sql);
   $sth->bindValue (':id', $id);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   while($row = $sth->fetch()){
          echo "<div id=frontpage>";
          echo "<t1><a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a></t1></br>";
          echo "<t3>In Stock: ".$row['onStock']."</t3></br>";
          if(intval($row['rabatt'])!= 0){
            echo "<t2>Price: $".(intval($row['price'])*(1-(intval($row['rabatt'])/100)))."</t2>";
         }else{
            echo "<t2>Price: $".$row['price']."</t2>";
        }
          echo "</div>";
   }
   ?>
</div>
</BODY>
</HTML>