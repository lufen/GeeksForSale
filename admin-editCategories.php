<?php
require_once "user.php";
CheckIfAdminLoggedIn();
?>

<?php
include 'Geeksforsaletop.php';
?>

<div id="content">
	<?php include 'admin-buttons.php'; ?>
	<t1> Edit top categories</t1></br>
    <form action="admin-editTopCategory.php" method="post">
      <select name="category">
        <?php
        $sql = 'select * from productcategory';
        $sth = $db->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);  
        while($row = $sth->fetch()){
          echo "<option value=\"".$row['id']."\">".$row['categoryName']."</option>";
        }
        ?>
      </select>
      <input type="submit" name="submit" value="Edit Category">
  </form>

  	</br><t1> Edit sub categories</t1></br>
    <form action="admin-editSubCategories.php" method="post">
      <select name="category">
        <?php
        $sql = 'select * from subcategory';
        $sth = $db->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);  
        while($row = $sth->fetch()){
          echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
        }
        ?>
      </select>
      <input type="submit" name="submit" value="Edit Category">
       </form>
</div>
</BODY>
