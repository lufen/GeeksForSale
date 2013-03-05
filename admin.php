<?php
require_once "user.php";
require_once 'db.php';
CheckIfAdminLoggedIn();

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
  <?php include 'admin-buttons.php'; ?>
  </div>
</BODY>
