<?php
include 'Geeksforsaletop.php';
?>
<div id="content">
  <t0>Search results </t0>
   <?php
   $search = '\'%'.mysql_real_escape_string($_POST['search']).'%\'';
   $sql = "SELECT * from products where name like $search OR id=:search or info like $search AND forSale=1";
   $sth = $db->prepare($sql);
   $sth->bindValue (':search', $_POST['search']);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   while($row = $sth->fetch()){
          echo "<div id=product>";
          echo "<t1><a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a></t1></br>";
          echo "<t3>In Stock: ".$row['onStock']."</t3></br>";
          if(intval($row['rabatt'])!= 0){
            echo "<t2>Price: $".intval($row['price'])*(intval($row['rabatt'])/100)."</t2>";
         }else{
            echo "<t2>Price: $".$row['price']."</t2>";
          
        }
          echo "</div>";
   }
   ?>
</div>
</BODY>
</HTML>