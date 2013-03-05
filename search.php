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
   <?php
   $sql = "Select * from products where name like '%:search%' OR id=:search";
   $sth = $db->prepare($sql);
   $sth->bindValue (':search', $_POST['search']);
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