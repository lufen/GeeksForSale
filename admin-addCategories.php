<?php
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';

if(isset($_POST['categoryName'])){
  // Add a new top category
  $sql = 'INSERT into productcategory (categoryName) values (:categoryName)';
  $sth = $db->prepare($sql);
  $sth->bindValue (':categoryName', $_POST['categoryName']);
  if($sth->execute()){
   header( 'Location: admin-addCategories.php' );
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
      header( 'Location: admin-addCategories.php' );
    }
  }
 
}
?> 

<div id= "content">
	<?php include 'admin-buttons.php'; ?>
	 <p> Add a new top category
  <form action="admin-addCategories.php" method="post">
    <input type="text" name="categoryName" required />
    <input type="submit" name="submit" value="Add top category">
  </form>

  <p> Add a new sub category
    <form action="admin-addCategories.php" method="post">
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
	
</div>
