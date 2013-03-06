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
  echo '<img src="data:image/png;base64,'.$data.'" />';
}
?>
<form method="get" action="productdetails.php">
  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
  <shortlabel for="Quantity">Quantity</shortlabel>
  <input type="number" name="Quantity"  min="0"  required/></br>  
  <input type="submit" value="Put in cart"/>
</form>
<?php 
require 'user.php';  
if(isUserLoggedIn() == true){
 echo '<form method="post" action="productExperience.php">';
 echo "<input type=\"hidden\" name=\"pID\" value=".$_GET['id']."/>";
 echo '<input type="submit" value="Click to add experience"/> </form>';
}else{
  echo "<t3> Please log in to add experience about this product</t3></br>";
} 
?>
<t2> Comments </t2>
<?php
$sql = "Select * from productexperience where productID=:id";
$sth = $db->prepare($sql);
$sth->bindValue (':id', $id);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);  
while($row = $sth->fetch()){
  echo '<div id=comment>';
  echo '<t2>Grade: </t2>';
  echo "<t3>".$row['grade']."</br>"; 
  echo "<t2I>".$row['comment']."</br>"; 
  echo '</div>';
}
?>
</div>
</BODY>
</HTML>