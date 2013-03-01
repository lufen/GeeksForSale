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
   <?php
   $id = $_GET['id'];
   $sql = "Select * from subcategory where id=:id";
   $sth = $db->prepare($sql);
   $sth->bindValue (':id', $id);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   $row = $sth->fetch();
   echo $row['name']."<br>";
   echo "Products in this category: ";

   $sql = "Select * from products where categoriID=:id";
   $sth = $db->prepare($sql);
   $sth->bindValue (':id', $id);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   echo "<br>";
   while($row = $sth->fetch()){
      if($row['forSale'] != "0")
         echo "<a href=\"productdetails.php?id=".$row['id']."\">".$row['name']."</a> Price: ".$row['price']." In Stock: ".$row['onStock']."<br>";
   }
   ?>
</div>
</BODY>
</HTML>