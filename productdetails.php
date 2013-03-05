<?php
session_start();
   // Save into basket, using p+productID as key
   // P because the array does not allow for numeric key
if (isset ($_GET['Quantity'])) {
   $key = "p".$_GET['id'];
   if (isset($_SESSION[$key])){
      $_SESSION[$key] = $_SESSION[$key] + $_GET['Quantity'];
   }else{
      $_SESSION[$key] = $_GET['Quantity'];
   }
   header( 'Location: shoppingbasket.php' );
}
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
   <?php
   echo "Details about product <br>";
   $id = $_GET['id'];
   $sql = "Select * from products where id=:id";
   $sth = $db->prepare($sql);
   $sth->bindValue (':id', $id);
   $sth->execute();
   $sth->setFetchMode(PDO::FETCH_ASSOC);  
   while($row = $sth->fetch()){
      echo "Name: ".$row['name']."<br>";
      echo "Details: ".$row['info']."<br>";
      echo "In stock: ".$row['onStock']."<br>";  
      if(intval($row['rabatt'])!= 0){
        echo "Discount: ".$row['rabatt']."%<br>";
        echo "Old price: ".$row['price']."</br>";
        echo "Price: ".intval($row['price'])*(intval($row['rabatt'])/100)."<br>";
      }else
        echo "Price: $".$row['price']."<br>";  
      
      $data = $row['pictures'];
//      echo "picture looks like this: ".$row['pictures']."<br>";
      echo '<img src="data:image/png;base64,'.$data.'" />';

   }
   ?>
   <form method="get" action="productdetails.php">
      <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
      <label for="Quantity">Quantity</label>
      <input type="number" name="Quantity"  min="0" required  /><br/>
      <input type="submit" value="Put in cart"/>
   </div>
</BODY>
</HTML>