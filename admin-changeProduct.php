<?php
require_once "db.php";
require_once "user.php";
CheckIfAdminLoggedIn();
include 'Geeksforsaletop.php';
?>
<div id= "content">
	<?php
		include 'admin-buttons.php';
		$sql = 'SELECT * FROM products where id = :id';

		$sth = $db->prepare($sql);
		$sth->bindValue(':id', $_GET['id']);
		$affectedRows = $sth->execute();
		$sth->setFetchMode(PDO::FETCH_ASSOC);

		$line = __LINE__;
		$row = $sth->fetch();
		if($affectedRows == 1)
		{
			?>
			<form action="admin-addProducts.php" method="post"
    		enctype="multipart/form-data">
				<label for="name">Name of product</label>
				<input type="text" name="name" required="required" value="<?php echo $row['name'];?>"/><br/>
				<label for="price">What does the product cost? $</label>
				<input type="number" name="Price" required="required" value="<?php echo $row['price'];?>"/><br/>
				<label for="information">Information about the product</label>
				<input type="text" name="information" required="required" value="<?php echo $row['info'];?>"/><br/>
				<label for="rabatt">Discount in percentage</label>
				<input type="number" name="rabatt" required="required" value="<?php echo $row['rabatt'];?>"/><br/>
	    	<select name="subcategory" selected="<?php echo $row['categoriID'];?>">
		      <?php
		      $sql = 'select name from subcategory';
		      $sth = $db->prepare($sql);
		      $sth->execute();
		      $sth->setFetchMode(PDO::FETCH_ASSOC);  
		      while($row = $sth->fetch()){
		        echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
		      }
		      ?>
    		</select><br>
				<input type="number" name="categoriID" required="required" value="<?php echo $row['categoriID'];?>"/><br/>
				<input type="submit" value="Submit changes"/></br>
			</form>		

			<?php
		}
	else
	{
		echo "Affected rows is ",$affectedRows," not 1 on line ", $line+1;
	}
	?>
</div>
