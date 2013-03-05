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
 </div>
 
 <div id="menu">
   <?php
   require_once 'menu.php';
   ?>
</div>
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