<?php
require_once "user.php";
require_once 'db.php';
CheckIfAdminLoggedIn();


if(isset($_POST['productName']))
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


?>

<?php
include 'Geeksforsaletop.php';

?>

<div id="content">
  <?php 
  include 'admin-buttons.php'; 
  ?>
  </div>
</BODY>
