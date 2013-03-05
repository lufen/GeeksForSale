<?php
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';
?> 

<div id= "content">
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
	
</div>
