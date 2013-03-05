<?php
require_once "db.php";
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';
?>
<div id= "content">
	<?php
		$sql = "Select * from productcategory";
		$sth = $db->prepare($sql);
		$sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);  
		while($categoryrow = $sth->fetch())
		{
			echo "<br><t1>".$categoryrow['categoryName']."</t1><br>";
				// Get subcategories
			$sql = "Select * from subcategory where categoryid = ".$categoryrow['id'];
			$sth2 = $db->prepare($sql);
			$sth2->execute();
			$sth2->setFetchMode(PDO::FETCH_ASSOC);
			while($subCategoryRow = $sth2->fetch())
			{
				echo "<t2I>".$subCategoryRow['name']."</t2I><br>";
				$subCategoryId = $subCategoryRow['id'];
				$sql = 'SELECT * from products where categoriID = $subCategoryId';
				$sth3 = $db->prepare($sql);
				$sth3->execute();
				$sth3->setFetchMode(PDO::FETCH_ASSOC);

				while($product = $sth->fetch())
				{

				}
				

			}
		}
/*
	?>
<p>Add user<br>
  <form action="admin.php" method="post"
  enctype="multipart/form-data">
    <label for="username">Username</label>
    <input type="text" name="username" required="required"/><br>
    <label for="streetAddress">Street address</label>
    <input type="text" name="streetAddress" required="required"/><br>
    <label for="postCode">Postal code</label>
    <input type="number" name="postCode" required="required" min=0 max=99999/><br>
    <label for="country">Country</label>
    <input type="text" name="country" required="required"/><br>
    <label for="email">E-mail</label>
    <input type="email" name="email" required="requried"/><br>
    <label for="password">Password</label>
    <input type="password" name="password" required="required"/><br>
    <label for="userLevel">User level. 0 for regular user, 1 for workers and 2 for administrators</label><br>
    <input type="number" name="userLevel" required="required" min=0 max=2/><br>
    <input type="submit" name="submit" value="Add new user">
  </form>
 </div>
 */
	?>
</div>
