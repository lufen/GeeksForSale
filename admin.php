<?php
require_once "user.php";
CheckIfAdminLoggedIn();
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

else if(isset($_POST['subcategoryName']))
{
  // Add new sub category
  $sql = 'select id from productcategory where categoryName = :categoryName';
  $sth = $db->prepare($sql);
  $sth->bindValue (':categoryName', $_POST['category']);
  $sth->execute();
  $sth->setFetchMode(PDO::FETCH_ASSOC);
    // only add if we only found one category
  if($sth->rowCount() === 1)
  {
      // Add the new sub category
    $row = $sth->fetch();
    $id = $row['id'];
    $sql = 'INSERT into subcategory (name, categoryid) values (:name, :categoryid)';
    $sth2 = $db->prepare($sql);
    $sth2->bindValue (':name', $_POST['subcategoryName']);
    $sth2->bindValue (':categoryid', $id);
    if($sth2->execute())
    {
      header( 'Location: admin.php' );
    }
  }
 
}
else if(isset($_POST['productName']))
{
   // Add new product
  if(isset($_FILES['picturefn']))
  {
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
      if($sth2->rowCount() === 1){
        echo "Added OK";
      }
    }
  }
}
else if(isset($_POST['username']))
{
  $username = $_POST['username'];
  $streetAddress = $_POST['streetAddress'];
  $postCode = $_POST['postCode'];
  $country = $_POST['country'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $userLevel = $_POST['userLevel'];
  try
  {
     registerUser($db,$username, $streetAddress, $postCode, $country, $email, $password, $userLevel);
           // Redirect back to homepage
     header( 'Location: admin.php' );
  }
  catch(Exception $e)
  {
       echo $e->getMessage();
  }
}


?>

<?php
include 'Geeksforsaletop.php';
?>

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
        <label for="productName">Name</label>
        <input type="text" name="productName" required="required"/><br>
        <label for=price>Price</label>
        <input type="number" name="price" required="required"/><br>
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

      <p>Add user<br>
        <form action="admin.php" method="post"
        enctype="multipart/form-data">
          <label for="username">Username</label>
          <input type="text" name="username" required="required"/><br>
          <label for="streetAddress">Street address</label>
          <input type="text" name="streetAddress" required="required"/><br>
          <label for="postCode">Postal code</label>
          <input type="number" name="postCode" required="required"/><br>
          <label for="country">Country</label>
          <input type="text" name="country" required="required"/><br>
          <label for="email">E-mail</label>
          <input type="email" name="email" required="requried"/><br>
          <label for="password">Password</label>
          <input type="password" name="password" required="required"/><br>
          <label for="userLevel">User level. 0 for regular user, 1 for workers and 2 for administrators</label><br>
          <input type="number" name="userLevel" required="required"/><br>
          <input type="submit" name="submit" value="Add new user">
        </form>
    </div>
  </BODY>
