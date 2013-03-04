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
  if(isset($_FILES['picturefn']))
  {
//    echo "picturefn set ", __LINE__;
    $picture = $_FILES['picturefn'];
    if(!empty($picture))
    {
      echo "picture was not empty\n", __LINE__;
      /*
      echo "Upload: " . $_FILES["picturefn"]["name"] . "<br>";
      echo "Type: " . $_FILES["picturefn"]["type"] . "<br>";
      echo "Size: " . ($_FILES["picturefn"]["size"] / 1024) . " kB<br>";
      echo "Stored in: " . $_FILES["picturefn"]["tmp_name"];
      */
      $ip = $_SERVER['REMOTE_ADDR'];
//      copy($picture, "./temporary/".$ip."");
      $filename1 = $_FILES["picturefn"]["tmp_name"];
      $fp1 = fopen($filename1, "r");
      $content1 = fread($fp1, filesize($filename1));
      fclose($fp1);
      $encoded = chunk_split(base64_encode($content1));
    }
    else
    {
      echo "picture was empty\n", __LINE__;
    }
  
    $sql = 'select id from subcategory where name = :subcategoryName';
    $sth = $db->prepare($sql);
    $sth->bindValue(':subcategoryName', $_POST['subcategory']);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    echo "found subcategory\n";
    if($sth->rowCount() === 1)
    {
      echo "there was only 1 subcategory\n";
      $row = $sth->fetch();
      $id = $row['id'];
//      $sql = 'INSERT INTO products (price, picture, name, info, onStock, forSale, rabatt, categoriid)
//             values (:price, :picture, :name, :info, :onStock, :forSale, :rabatt, :categoriid)';
      $sql = 'INSERT INTO products values (:price, :picture, :name, :info, :onStock, :forSale, :rabatt, :categoriid)';
      $sth2 = $db->prepare($sql);
      echo "sql statement: ".$sql;
      echo "Binding values\n";
      //var_dump($_POST);
      $sth2->bindValue(':price', $_POST['price']);
      $sth2->bindValue(':picture', $encoded);
      $sth2->bindValue(':name', $_POST['productName']);
      $sth2->bindValue(':info', $_POST['info']);
      $sth2->bindValue(':onStock', $_POST['onStock']);
      $sth2->bindValue(':forSale', $_POST['forSale']);
      $sth2->bindValue(':rabatt', $_POST['rabatt']);
      $sth2->bindValue(':categoriid', $id);
      echo "Trying to execute sql\n";
      if($sth2->execute())
      {
        header('Location: admin.php');
      }
    }
  }
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

    <p> <br>Add a new product to
      <form action="admin.php" method="post"
      enctype="multipart/form-data">
        <select name="subcategory">
          <?php
          $sql = 'select name from subcategory';
          $sth = $db->prepare($sql);
          $sth->execute();
          $sth->setFetchMode(PDO::FETCH_ASSOC);  
          while($row = $sth->fetch()){
            echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
          }
          ?>
        </select><br><br>
        <label for="name">Name</label>
        <input type="text" name="productName" required="required"/><br>
        <label for=price>Price</label>
        <input type="number" name = "price" required="required"/><br>
        <label for=picture>Picture</label>
        <input type="file" name="picturefn" required="required"><br>
        <label for="info">Information about the product</label>
        <input type="text" name="info" required="required"/><br>
        <label for="onStock">Number of that product for sale</label>
        <input type="number" name="onStock" required="required"/><br>
        <label for="forSale">Is this product for sale? 1 for yes, 0 for no</label>
        <input type="bool" name=forSale required="required"><br>
        <label for="rabatt">Discount in percentage.</label>
        <input type="number" name=rabatt required="required"><br>
        <input type="submit" name="submit" value="Add new product">
      </form>




    </div>
  </BODY>
