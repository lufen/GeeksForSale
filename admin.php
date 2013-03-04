<?php
require_once 'db.php';

if(isset($_POST['categoryName'])){
    // Add a new top category
  $sql = 'INSERT into productcategory (categoryName) values (:categoryName)';
  $sth = $db->prepare($sql);
  $sth->bindValue (':categoryName', $_POST['categoryName']);
  if($sth->execute()){
   header( 'Location: admin.php' );
 }
}
else if(isset($_POST['subcategoryName'])){
    // Get ID of top category
  $sql = 'select id from productcategory where categoryName = :categoryName';
  $sth = $db->prepare($sql);
  $sth->bindValue (':categoryName', $_POST['category']);
  $sth->execute();
  $sth->setFetchMode(PDO::FETCH_ASSOC);
    // only add if we only found one category
  if($sth->rowCount() === 1){
      // Add the new sub category
    $row = $sth->fetch();
    $id = $row['id'];
    $sql = 'INSERT into subcategory (name, categoryid) values (:name, :categoryid)';
    $sth2 = $db->prepare($sql);
    $sth2->bindValue (':name', $_POST['subcategoryName']);
    $sth2->bindValue (':categoryid', $id);
    if($sth2->execute()){
      header( 'Location: admin.php' );
    }
  }
}else if(isset($_POST['productName'])){
  echo "hei";
}
?>

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
  <h1>
   <?php
   echo "Geeks for sale!!!";
   ?>
 </h1>
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
 <p> Add a new top category
  <form action="admin.php" method="post">
    <input type="text" name="categoryName" required />
    <input type="submit" name="submit" value="Add top category">
  </form>

  <p> Add a new sub category
    <form action="admin.php" method="post">
      <select name="category">
        <?php
        $sql = 'select categoryName from productcategory';
        $sth = $db->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);  
        while($row = $sth->fetch()){
          echo "<option value=\"".$row['categoryName']."\">".$row['categoryName']."</option>";
        }
        ?>
      </select>
      <input type="text" name="subcategoryName" required />
      <input type="submit" name="submit" value="Add subcategory">
    </form>

    <p> Add a new product
      <form action="admin.php" method="post">
        <select name="subcatory">
          <?php
          $sql = 'select name from subcategory';
          $sth = $db->prepare($sql);
          $sth->execute();
          $sth->setFetchMode(PDO::FETCH_ASSOC);  
          while($row = $sth->fetch()){
            echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
          }
          ?>
        </select>
        <input type="text" name="productName" required />
        <input type="submit" name="submit" value="Add new product">
      </form>


    </div>
  </BODY>
</HTML>