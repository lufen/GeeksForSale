<?php
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';

function AddProduct()
{
  require 'db.php';
 // Add new product
  $picture = $_FILES['picturefn'];
  if(!empty($picture))
  {
    $ip = $_SERVER['REMOTE_ADDR'];
    $filename1 = $_FILES["picturefn"]["tmp_name"];
    $fp1 = fopen($filename1, "r");
    $content1 = fread($fp1, filesize($filename1));
    fclose($fp1);
    $encoded = chunk_split(base64_encode($content1));
  }  
  $sql = 'select id from subcategory where name = :subcategoryName';
  $sth = $db->prepare($sql);
  $sth->bindValue(':subcategoryName', $_POST['subcategory']);
  $sth->execute();
  $sth->setFetchMode(PDO::FETCH_ASSOC);
  if($sth->rowCount() === 1)
  {
    $row = $sth->fetch();
    $id = $row['id'];
    $sql = 'INSERT INTO products (price, pictures, name, info, onStock, forSale, rabatt, categoriId) values (:price, :pictures, :name, :info, :onStock, :forSale, :rabatt, :categoriId)';
    $sth2 = $db->prepare($sql);
    $sth2->bindValue(':price', $_POST['price']);
    $sth2->bindValue(':pictures', $encoded);
    $sth2->bindValue(':name', $_POST['productName']);
    $sth2->bindValue(':info', $_POST['info']);
    $sth2->bindValue(':onStock', $_POST['onStock']);
    $sth2->bindValue(':forSale', $_POST['forSale']);
    $sth2->bindValue(':rabatt', $_POST['rabatt']);
    $sth2->bindValue(':categoriId', $id);
    $sth2->execute();
    if($sth2->rowCount() === 1)
    {
      echo "Added OK";
    }
  }
}
?> 

<div id= "content">
	<?php include 'admin-buttons.php'; ?>
  <t1>Add a new product to</t1> </br>
    <?php 
    if(isset($_POST['productName'])){
      AddProduct();
    }
    ?>
    <form action="admin-addProducts.php" method="post"
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
    <label for="productName">Name</label>
    <input type="text" name="productName" required="required"/><br>
    <label for=price>Price</label>
    <input type="number" name="price" required="required" min=1 max=99999/><br>
    <label for=picture>Picture</label>
    <input type="file" name="picturefn" required="required"><br>
    <label for="info">Information about the product</label>
    <input type="text" name="info" required="required"/><br><br>
    <label for="onStock">Number of that product for sale</label>
    <input type="number" name="onStock" required="required" min=0 max=9999/><br><br>
    <label for="forSale">Is this product for sale?</label>
      <select id="forSale" name="forSale" required>
          <option value="0">Not for sale</option>
          <option value="1">For sale</option>
      </select></br></br>
    <label for="rabatt">Discount in percentage.</label>
    <input type="number" name=rabatt required="required" min=0 max=99><br><br>
    <input type="submit" name="submit" value="Add new product">
  </form>
</div>